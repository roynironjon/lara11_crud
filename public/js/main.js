window.addEventListener("DOMContentLoaded",() => {
	const t = new Tree("canvas");
});

class Tree {
	constructor(qs) {
		this.C = document.querySelector(qs);
		this.c = this.C?.getContext("2d");
		this.S = window.devicePixelRatio;
		this.W = 750;
		this.H = 700;
		this.branches = [];
		this.darkTheme = false;
		this.debug = false;
		this.decaying = false;
		this.floorY = 685;
		this.fruit = [];
		this.gravity = 0.098;
		this.loopDelay = 500;
		this.loopEnd = Utils.dateValue;
		this.maxGenerations = 10;

		if (this.C) this.init();
	}
	get allBranchesComplete() {
		const { branches, maxGenerations } = this;

		return branches.filter(b => {
			const isLastGen = b.generation === maxGenerations;
			return b.progress >= 1 && isLastGen;
		}).length > 0;
	}
	get allFruitComplete() {
		return !!this.fruit.length && this.fruit.every(f => f.progress === 1);
	}
	get allFruitFalling() {
		return !!this.fruit.length && this.fruit.every(f => f.timeUntilFall <= 0);
	}
	get debugInfo() {
		return [
			{ item: 'Pixel Ratio', value: this.S },
			{ item: 'Branches', value: this.branches.length },
			{ item: 'Branches Complete', value: this.allBranchesComplete },
			{ item: 'Decaying', value: this.decaying },
			{ item: 'Fruit', value: this.fruit.length },
			{ item: 'Fruit Complete', value: this.allFruitComplete }
		];
	}
	get lastGeneration() {
		const genIntegers = this.branches.map(b => b.generation);
		return [...new Set(genIntegers)].pop();
	}
	get trunk() {
		return {
			angle: 0,
			angleInc: 20,
			decaySpeed: 0.0625,
			diameter: 10,
			distance: 120,
			distanceFade: 0.2,
			generation: 1,
			growthSpeed: 0.04,
			hadBranches: false,
			progress: 0,
			x1: 400,
			y1: 680,
			x2: 400,
			y2: 560
		};
	}
	detectTheme(mq) {
		this.darkTheme = mq.matches;
	}
	draw() {
		const { c, W, H, debug, branches, fruit } = this;

		c.clearRect(0,0,W,H);

		const lightness = this.darkTheme ? 90 : 10;
		const foreground = `hsl(223,10%,${lightness}%)`;
		c.fillStyle = foreground;
		c.strokeStyle = foreground;

		// debug info
		if (debug === true) {
			const textX = 24;

			this.debugInfo.forEach((d,i) => {
				c.fillText(`${d.item}: ${d.value}`,textX,24 * (i + 1));
			});
		}

		// branches
		branches.forEach(b => {
			c.lineWidth = b.diameter;
			c.beginPath();
			c.moveTo(b.x1,b.y1);
			c.lineTo(
				b.x1 + (b.x2 - b.x1) * b.progress,
				b.y1 + (b.y2 - b.y1) * b.progress
			);
			c.stroke();
			c.closePath();
		});

		// fruit
		fruit.forEach(f => {
			c.globalAlpha = f.decayTime	< f.decayFrames ? f.decayTime / f.decayFrames : 1;
			c.beginPath();
			c.arc(f.x,f.y,f.r * f.progress,0,2 * Math.PI);
			c.fill();
			c.closePath();
			c.globalAlpha = 1;
		});
	}
	grow() {
		// start with the trunk
		if (!this.branches.length && Utils.dateValue - this.loopEnd > this.loopDelay) {
			this.branches.push(this.trunk);
		}

		if (!this.allBranchesComplete) {
			this.branches.forEach(b => {
				if (b.progress < 1) {
					// branch growth
					b.progress += b.growthSpeed;

					if (b.progress > 1) {
						b.progress = 1;

						// grow fruit if the generation is the last
						if (b.generation === this.maxGenerations) {
							this.fruit.push({
								decayFrames: 18,
								decayTime: 150,
								progress: 0,
								speed: 0.04,
								timeUntilFall: Utils.randomInt(0,300),
								x: b.x2,
								y: b.y2,
								r: Utils.randomInt(4,6),
								restitution: 0.2 * (1 - b.y2 / this.floorY),
								yVelocity: 0
							});
						}
					}

				} else if (!b.hadBranches && b.generation < this.maxGenerations) {
					b.hadBranches = true;
					// create two new branches
					const lean = 5;
					const angleLeft = b.angle - (b.angleInc + Utils.randomInt(-lean,lean));
					const angleRight = b.angle + (b.angleInc + Utils.randomInt(-lean,lean));
					const distance = b.distance * (1 - b.distanceFade);
					const generation = b.generation + 1;

					const leftBranch = {
						angle: angleLeft,
						angleInc: b.angleInc,
						decaySpeed: b.decaySpeed,
						diameter: Math.floor(b.diameter * 0.9),
						distance,
						distanceFade: b.distanceFade,
						generation,
						growthSpeed: b.growthSpeed,
						hadBranches: false,
						progress: 0,
						x1: b.x2,
						y1: b.y2,
						x2: b.x2 + Utils.endPointX(angleLeft,distance),
						y2: b.y2 - Utils.endPointY(angleLeft,distance)
					};

					const rightBranch = {...leftBranch};
					rightBranch.angle = angleRight;
					rightBranch.x2 = b.x2 + Utils.endPointX(angleRight,distance);
					rightBranch.y2 = b.y2 - Utils.endPointY(angleRight,distance);

					this.branches.push(leftBranch,rightBranch);
				}
			});
		}
		if (!this.allFruitComplete) {
			this.fruit.forEach(f => {
				if (f.progress < 1) {
					f.progress += f.speed;

					if (f.progress > 1) f.progress = 1;
				}
			});
		}

		if (this.allBranchesComplete && this.allFruitComplete) this.decaying = true;
	}
	decay() {
		if (this.fruit.length) {
			// fruit fall
			this.fruit = this.fruit.filter(f => f.decayTime > 0);

			this.fruit.forEach(f => {
				if (f.timeUntilFall <= 0) {
					f.y += f.yVelocity;
					f.yVelocity += this.gravity;

					const bottom = this.floorY - f.r;

					if (f.y >= bottom) {
						f.y = bottom;
						f.yVelocity *= -f.restitution;
					}

					--f.decayTime;

				} else if (!f.decaying) {
					--f.timeUntilFall;
				}
			});
		}
		if (this.allFruitFalling || !this.fruit.length) {
			// branch decay
			this.branches = this.branches.filter(b => b.progress > 0);

			this.branches.forEach(b => {
				if (b.generation === this.lastGeneration) b.progress -= b.decaySpeed;
			});
		}
		if (!this.branches.length && !this.fruit.length) {
			// back to the trunk
			this.decaying = false;
			this.loopEnd = Utils.dateValue;
		}
	}
	init() {
		this.setupCanvas();
		this.setupThemeDetection();
		this.run();
	}
	run() {
		this.draw();

		if (this.decaying) this.decay();
		else this.grow();

		requestAnimationFrame(this.run.bind(this));
	}
	setupCanvas() {
		const { C, c, W, H, S } = this;

		// properly scale the canvas based on the pixel ratio
		C.width = W * S;
		C.height = H * S;
		C.style.width = "auto";
		C.style.height = "100%";
		c.scale(S,S);

		// set unchanging styles
		c.font = "16px sans-serif";
		c.lineCap = "round";
		c.lineJoin = "round";
	}
	setupThemeDetection() {
		if (window.matchMedia) {
			const mq = window.matchMedia("(prefers-color-scheme: dark)");
			this.detectTheme(mq);
			mq.addListener(this.detectTheme.bind(this));
		}
	}
}

class Utils {
	static get dateValue() {
		return +new Date();
	}
	static endPointX(angleInDeg,distance) {
		return Math.sin(angleInDeg * Math.PI / 180) * distance;
	}
	static endPointY(angleInDeg,distance) {
		return Math.cos(angleInDeg * Math.PI / 180) * distance;
	}
	static randomInt(min,max) {
		return min + Math.round(Math.random() * (max - min));
	}
}

// mouse ani js code here
var App = {};

jQuery(document).ready(function() {
  // Setup canvas and app
  App.setup();
  // Launch animation loop
  App.frame = function() {
    App.update();
    window.requestAnimationFrame(App.frame);
  };
	App.frame();

  jQuery('canvas#ourCanvas').on('click', function(event) {
    App.hasUserClicked = !App.hasUserClicked;
  });

  jQuery('canvas#ourCanvas').on('mousemove', function(event) {
    App.target.x = event.pageX;
    App.target.y = event.pageY;
  });
});

App.setup = function() {
  // Setup canvas and get canvas context
  var canvas = document.createElement('canvas');
  canvas.height = window.innerHeight;
  canvas.width = window.innerWidth;
  canvas.id = 'ourCanvas';
  document.body.appendChild(canvas);
  this.ctx = canvas.getContext('2d');
  this.width = canvas.width;
  this.height = canvas.height;

  // Define a few useful elements
  this.stepCount = 0;
  this.hasUserClicked = false;
  this.xC = canvas.width / 2;
  this.yC = canvas.height / 2;
  this.target = {
    x: this.xC,
    y: this.yC,
    radius: 20
  };
  this.armsPop = 20;
  //this.particlesPerArm = 15;

  // Create initial targets and arms
  this.arms = [];
  for (var i = 0; i < this.armsPop; i++) {
    this.arms.push([]);
  }
  // Fill initial arms
  this.initialBirth();

  // Some forces
  this.gravity = -1;
  this.springStiffness = 0.5;
  this.viscosity = 0.1;
  this.isElastic = false;
};
App.initialBirth = function() {
  for (var armIndex = 0; armIndex < this.arms.length; armIndex++) {
    var arm = this.arms[armIndex];
    // Random arm length! Sorta.
    var particlesNb = 20 + Math.ceil(20 * Math.random());
    for (var i = 0; i < particlesNb; i++) {
      var x = this.width * Math.random();
      var y = this.height * Math.random();
      var particle = {
        x: x,
        y: y,
        xLast: x,
        yLast: y,
        xSpeed: 0,
        ySpeed: 0,
        stickLength: 10,
        name: 'seed' + this.stepCount
      };

      arm.push(particle);
    }
  }

};
App.update = function() {
  // Evolve system
  this.evolve();
  // Move particles
  this.move();
  // Draw particles
  this.draw();
};
App.evolve = function() {
  this.stepCount++;
  this.target.radius = 50 + 30 * Math.sin(this.stepCount / 10);
};
App.move = function() {
  // This is inverse kinematics, the particles form an arm with N joints, and its shape adapts with a target contraint
  // Move target point
  if (!this.hasUserClicked) {
    this.target.x = this.xC + 150 * Math.cos(this.stepCount / 50);
    this.target.y = this.yC + 150 * Math.sin(this.stepCount / 20);
  }

  // Move particles accordingly (on each arm)
  for (var armIndex = 0; armIndex < this.arms.length; armIndex++) {
    var arm = this.arms[armIndex];
    var ownTargetAngle = 2 * Math.PI * armIndex / this.arms.length;
    var ownTarget = {
      x: this.target.x + this.target.radius * Math.cos(ownTargetAngle),
      y: this.target.y + this.target.radius * Math.sin(ownTargetAngle),
    }
    for (var i = 0; i < arm.length; i++) {
      var p = arm[i];
      // Leading particle (particle bound to head at first, then the preceding particle)
      var pLead = ( i == 0 ? ownTarget : arm[i-1] );
      var angle = segmentAngleRad(p.x, p.y, pLead.x, pLead.y, false);
      var dist = Math.sqrt(Math.pow(p.x - pLead.x, 2) + Math.pow(p.y - pLead.y, 2));
      var translationDist = dist - p.stickLength;
      if (translationDist < 0) {
        angle += Math.PI;
        translationDist = Math.abs(translationDist);
      }
      /* Kinetic binding */
      // Rotation, then translation for each particle/stick from head to tail
      var dx = translationDist * Math.cos(angle);
      var dy = translationDist * Math.sin(angle);
      if (!this.isElastic) {
        p.x += dx;
        p.y -= dy;
      }
      /* Forces */
      var xAcc = this.springStiffness * dx - this.viscosity * p.xSpeed;
      var yAcc = this.springStiffness * dy + this.gravity - this.viscosity * p.ySpeed;
      p.xSpeed += xAcc;
      p.ySpeed += yAcc;
      p.x += 0.1 * p.xSpeed;
      p.y -= 0.1 * p.ySpeed;
    }
  }

};
App.draw = function() {
  // Add transparent layer for trace effect
  this.ctx.beginPath();
  this.ctx.rect(0, 0, this.width, this.height);
  this.ctx.fillStyle = 'rgba(0, 0, 0, 0.3)';
  this.ctx.fill();

  // Draw target
  this.ctx.beginPath();
  this.ctx.arc(this.target.x, this.target.y, 15, 0, 2 * Math.PI, false);
  this.ctx.fillStyle = 'rgba(255, 255, 255, 0.1)';
  this.ctx.fill();

  // Draw particles
  for (var armIndex = 0; armIndex < this.arms.length; armIndex++) {
    var arm = this.arms[armIndex];
    for (var i = 0; i < arm.length; i++) {
      var particle = arm[i];
      if (i != 0) { var particleLead = arm[i-1]; }

      // Draw particle
      this.ctx.beginPath();
      this.ctx.arc(particle.x, particle.y, 0.3 * (arm.length - i), 0, 2 * Math.PI, false);
      this.ctx.strokeStyle = 'hsla(' + (200 + i * 4) + ', 90%, 50%, 0.7)';
      this.ctx.stroke();
      // Draw its stick
      this.ctx.beginPath();
      this.ctx.lineWidth = 1;
      this.ctx.strokeStyle = 'hsla(' + (180 + i * 4) + ', 80%, 50%, 0.7)';
      if (i == 0) this.ctx.moveTo(this.target.x, this.target.y);
      else this.ctx.moveTo(particleLead.x, particleLead.y);
      this.ctx.lineTo(particle.x, particle.y);
      this.ctx.stroke();

    }
  }
};



/**
 * @param {Number} Xstart X value of the segment starting point
 * @param {Number} Ystart Y value of the segment starting point
 * @param {Number} Xtarget X value of the segment target point
 * @param {Number} Ytarget Y value of the segment target point
 * @param {Boolean} realOrWeb true if Real (Y towards top), false if Web (Y towards bottom)
 * @returns {Number} Angle between 0 and 2PI
 */
segmentAngleRad = function(Xstart, Ystart, Xtarget, Ytarget, realOrWeb) {
	var result;// Will range between 0 and 2PI
	if (Xstart == Xtarget) {
		if (Ystart == Ytarget) {
			result = 0;
		} else if (Ystart < Ytarget) {
			result = Math.PI/2;
		} else if (Ystart > Ytarget) {
			result = 3*Math.PI/2;
		} else {}
	} else if (Xstart < Xtarget) {
		result = Math.atan((Ytarget - Ystart)/(Xtarget - Xstart));
	} else if (Xstart > Xtarget) {
		result = Math.PI + Math.atan((Ytarget - Ystart)/(Xtarget - Xstart));
	}

	result = (result + 2*Math.PI)%(2*Math.PI);

	if (!realOrWeb) {
		result = 2*Math.PI - result;
	}

	return result;
}


