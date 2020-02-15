import TweenLite from 'gsap';

export default function ScrollTo(options) {
  const block = typeof options.anchor === 'string' ? document.querySelector(`${options.anchor}`) : false;
  const header = document.querySelector('.header');
  const speed = typeof options.speed === 'number' ? options.speed : 1;
  const offset = typeof options.offset === 'number' ? options.offset : false;

  if (block) {
    const blockBox = block.getBoundingClientRect();
    let blockPos = blockBox.top + window.pageYOffset;
    if (header && window.getComputedStyle(header).position === 'fixed') {
      blockPos -= header.offsetHeight;
    }
    if (offset) {
      blockPos -= offset;
    }
    TweenLite.to(
      [document.body, document.documentElement],
      speed, { scrollTop: blockPos },
    );
  }
}
