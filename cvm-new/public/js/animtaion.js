
// =========================

let scrollUp = document.querySelector('.headerNavbar');

ScrollTrigger.create({
  start: 'top -50',
  end: 99999,
  // markers: true,
  toggleClass: { className: 'jwpnavbar--scrolled', targets: '.headerNavbar' }
});

ScrollTrigger.create({
  start: 'top -300',
  end: 99999,
  toggleClass: { className: 'jwpnavbar--up', targets: '.headerNavbar' },
  onUpdate: ({ direction }) => {
    if (direction == -1) {
      scrollUp.classList.remove('jwpnavbar--up');
    } else {
      scrollUp.classList.add('jwpnavbar--up');
    }
  }
});


// ================================

const sections = gsap.utils.toArray('.inner_wraper');

sections.forEach(section => {
  gsap.to(section, {
    opacity: 0,
    scale: 0.8,
    y: -200,
    scrollTrigger: {
      trigger: section,
      scrub: true,
      start: "bottom bottom",
      pin: true,
      pinSpacing: false,
    }
  })
})


gsap.from(".lineShape", {
  scrollTrigger: {
    trigger: ".lineShape",
    scrub: 1,
    start: "top bottom",
    end: "top top"
  },
  x: 100,
  transformOrigin: "right center",
  ease: "none"
});



// let titleOne = new SplitText(".hero__title");
// let oneWords = titleOne.lines;

// gsap.from(oneWords, {
//   opacity: 0,
//   duration: 1.5,
//   y: 80,
//   ease: "power4",
//   stagger: {
//     each: 0.15
//   },
//   scrollTrigger: {
//     toggleActions: "restart pause resume reset"
//   }
// });

// gsap.config({ trialWarn: false });
// console.clear();
// gsap.registerPlugin(SplitText);
// // const split = new SplitText(".titleGreathorned", { type: "lines" });

// split.lines.forEach((target) => {
//   gsap.to(target, {
//     backgroundPositionX: 0,
//     ease: "none",
//     duration: 2, // Adjust the duration as needed
//     scrollTrigger: {
//       toggleActions: "restart pause resume reset"
//     }
//   });
// });


gsap.to(".leftMove", {
  xPercent: -10,
  scrollTrigger: {
    trigger: ".leftMove",
    start: "bottom bottom",
    // pin: true,
    scrub: 0.5
  }
});
gsap.to(".rightMove", {
  xPercent: 10,
  scrollTrigger: {
    trigger: ".rightMove",
    start: "20% bottom",
    // pin: true,
    scrub: 0.5
  }
});

const processSection = gsap.utils.toArray('.inner_pd');

processSection.forEach(section => {
  gsap.to(section, {
    scale: .98,
    scrollTrigger: {
      trigger: ".process_desgin",
      scrub: .5,
      start: "50% bottom",
      end: "center center",
      // markers: true
    }
  })
})



let text = gsap.utils.toArray(".revealer-text");
text.forEach((el, i) => {
  gsap.from(el, {
    yPercent: 120,
    duration: .6,
    scrollTrigger: {
      trigger: el,
      start: "bottom bottom",
      end: "top top",
      toggleActions: "restart none none reset"
    }
  });
});


// =========================

function animateFrom(elem, direction) {
  direction = direction || 1;
  var x = 0,
    y = direction * 100;
  if (elem.classList.contains("gs_reveal_fromLeft")) {
    x = -100;
    y = 0;
  } else if (elem.classList.contains("gs_reveal_fromRight")) {
    x = 100;
    y = 0;
  }
  elem.style.transform = "translate(" + x + "px, " + y + "px)";
  elem.style.opacity = "0";
  gsap.fromTo(elem, { x: x, y: y, autoAlpha: 0 }, {
    duration: 1.25,
    x: 0,
    y: 0,
    autoAlpha: 1,
    ease: "expo",
    overwrite: "auto"
  });
}

function hide(elem) {
  gsap.set(elem, { autoAlpha: 0 });
}

document.addEventListener("DOMContentLoaded", function () {
  gsap.registerPlugin(ScrollTrigger);

  gsap.utils.toArray(".gs_reveal").forEach(function (elem) {
    hide(elem); // assure that the element is hidden when scrolled into view

    ScrollTrigger.create({
      trigger: elem,
      // markers: true,
      onEnter: function () { animateFrom(elem) },
      // onEnterBack: function () { animateFrom(elem, -1) },
      // onLeave: function () { hide(elem) } // assure that the element is hidden when scrolled into view
    });
  });
});


// ============================

gsap.registerPlugin(ScrollTrigger);

const Marquee = function (el, dir, canReverse) {
  this.el = el;

  let direction = dir ? dir : 1; // 1 = forward, -1 = backward scroll
  console.log(direction)

  this.tl = (el, settings, reverse) => {
    if (!canReverse) reverse = false;

    const tl = gsap.timeline({
      repeat: -1,
      onReverseComplete() {
        this.totalTime(this.rawTime() + this.duration() * 10);
      }
    });

    settings = settings || {};
    settings.ease || (settings.ease = 'none');

    let clone = el.cloneNode(true);
    let clone2 = el.cloneNode(true);
    let clone3 = el.cloneNode(true);
    let clone4 = el.cloneNode(true);
    let clone5 = el.cloneNode(true);
    el.parentNode.appendChild(clone);
    el.parentNode.appendChild(clone2);
    el.parentNode.appendChild(clone3);
    el.parentNode.appendChild(clone4);
    el.parentNode.appendChild(clone5);

    tl.to([el, clone, clone2, clone3, clone4, clone5], {
      xPercent: reverse ? 100 * direction : -100 * direction, ...settings
    }, 0);

    return tl;
  };

  const anim = this.tl(this.el, { duration: 15 });

  this.init = () => {
    ScrollTrigger.create({
      onUpdate(self) {
        if (self.direction !== direction) {
          if (canReverse) direction *= -1;
          gsap.to(anim, {
            timeScale: direction,
            overwrite: true
          });
        }
      }
    });
  };

  this.pause = () => {
    anim.pause();
  };

  this.resume = () => {
    anim.resume();
  };
}


const wrappers = document.querySelectorAll('.marquee__wrapper');

wrappers.forEach((wrapper) => {
  const inner = wrapper.querySelector('.marquee__inner');
  const el = wrapper.querySelector('.marquee');
  const direction = (el.dataset.direction == 'right') ? -1 : 1;

  const marquee = new Marquee(el, direction, true);

  marquee.init();

  ScrollTrigger.create({
    trigger: wrapper,
    // onEnter: () => marquee.resume(),
    // onLeave: () => marquee.pause(),
    // onEnterBack: () => marquee.resume(),
    // onLeaveBack: () => marquee.pause(),
    animation: gsap.to(inner, { x: direction * -1000 }),
    scrub: true,
  });
});

// ======================
let images = gsap.utils.toArray(".reveal-img");
images.forEach((el) => {
  gsap.from(el, {
    // opacity: 0,
    yPercent: 10,
    scale: 1.2,
    duration: 1.5,
    scrollTrigger: {
      trigger: el,
      start: "top bottom",
      end: "bottom top",
      //markers: true,
      toggleActions: "restart pause resume pause"
    }
  });
});


// ========================

gsap.to(".career .leftMove", {
  xPercent: -10,
  scrollTrigger: {
    trigger: ".career .leftMove",
    start: "bottom bottom",
    // pin: true,
    scrub: 0.5
  }
});
gsap.to(".career .rightMove", {
  xPercent: 10,
  scrollTrigger: {
    trigger: ".career .rightMove",
    start: "20% bottom",
    // pin: true,
    scrub: 0.5
  }
});


// =============================================

//Change width and time on your desire

initMarquee(190, 27)

function initMarquee(boxWidth, time) {
  const boxElement = $('.marquee__part');
  const boxLength = boxElement.length;
  const wrapperWidth = boxWidth * boxLength;
  const windowWidth = $(window).width();

  boxElement.parent().css('left', '-' + boxWidth + 'px');
  boxElement.css('width', boxWidth + 'px');

  gsap.set(".marquee__part", {
    x: (i) => i * boxWidth
  });

  gsap.to(".marquee__part", {
    duration: time,
    ease: "none",
    x: "-=" + wrapperWidth,
    modifiers: {
      x: gsap.utils.unitize(
        function (x) {
          return parseFloat(x + windowWidth + boxWidth) % wrapperWidth
        }
      )
    },
    repeat: -1
  });

}

// ===========================
// gsap.registerPlugin(ScrollTrigger, ScrollSmoother);

// // create the smooth scroller FIRST!
// const smoother = ScrollSmoother.create({
//   content: "#scrollsmoother-container",
//   smooth: 1.5,
//   normalizeScroll: true,
//   ignoreMobileResize: true,
//   effects: true,
//   //preventDefault: true,
//   //ease: 'power4.out',
//   //smoothTouch: 0.1, 
// });




// ===========================
const cursor = document.querySelector(".cb-cursor");
window.onpointermove = event => {
  const { clientX, clientY } = event;
  cursor.animate({
    left: `${clientX}px`,
    top: `${clientY}px`
  }, { duration: 3000, fill: "forwards" })
}
const elements = [...document.querySelectorAll(".case a")]
elements.map(element => {
  element.onmouseover = () => {
    cursor.classList.add("-video")
  }
  element.onmouseout = () => {
    cursor.classList.remove("-video")
  }
})

// =====================

gsap.to(".form_wrapper", {
  ease: "none",
  scrollTrigger: {
    trigger: ".contact_info",
    scrub: 1,
    pin: true,
    // end: "+=10",
  },
});


// ============================== ourApproach

gsap.set('.ourApproach .content', { autoAlpha: 0 })

var headlines = gsap.utils.toArray(".ourApproach .text");

var totalDuration = 2000;
var singleDuration = totalDuration / headlines.length;


const lineTimeline = gsap.timeline();

ScrollTrigger.create({
  trigger: ".ourApproach .grid",
  start: "top top",
  end: "+=" + totalDuration,
  //markers: true,
  pin: true,
  scrub: true,
  animation: lineTimeline,
});


lineTimeline
  .to('.sideline', { duration: 1 }, 0)
  .to('.sideline', { duration: 0.9, scaleY: 1, ease: "none" }, 0)


headlines.forEach((elem, i) => {

  const smallTimeline = gsap.timeline();

  const content = document.querySelector('.content-wrap');
  const relevantContent = content.querySelector('.ourApproach div.content-' + i);

  ScrollTrigger.create({
    trigger: ".ourApproach",
    start: "top -=" + (singleDuration * i),
    end: "+=" + singleDuration,
    animation: smallTimeline,
    toggleActions: "play reverse play reverse",

  });

  smallTimeline
    //.to(elem,{ duration: 0.25, fontSize: "40px", color: "orange"}, 0)  
    .to(elem, { duration: 0.25, color: "#cd1f7c", scale: 1 }, 0)
    .to(elem, { duration: 0.25 }, 0)
    .to(relevantContent, { duration: 0.25, y: 0, autoAlpha: 1 }, 0)
    ;

});


// =========================== parallax background ===========================

gsap.registerEffect({
  name: "zoom",
  effect: (targets, config) => {
    const vars = { transformOrigin: "0px 0px", ...config },
      { scale, origin } = config,
      clamp = gsap.utils.clamp(-100 * (scale - 1), 0);
    delete vars.origin;
    vars.xPercent = clamp((0.5 - origin[0] * scale) * 100);
    vars.yPercent = clamp((0.5 - origin[1] * scale) * 100);
    vars.overwrite = "auto";
    return gsap.to(targets, vars);
  },
  extendTimeline: true,
  defaults: { origin: [0.5, 0.5], scale: 2 }
});


gsap.utils.toArray(".banner_img").forEach((bannerSection, index) => {
  ScrollTrigger.create({
    trigger: bannerSection,
    start: "center 100%",
    end: "+=100%",
    onToggle(self) {
      if (self.isActive) { // if it enters forward or backward
        gsap.effects.zoom(".banner_img .inner_image", {
          scale: 1.1,
          // origin: zoom.origin,
          duration: 1.5,
          ease: "power1.inOut"
        });
      }
    }
  });
});


// =======================
$(window).on('beforeunload', function () {
  $(window).scrollTop(0);
});