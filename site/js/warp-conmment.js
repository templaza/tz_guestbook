/*
 *  This is just a utitlity script so we can
 *  add random content to masonry-ed layouts
 */

var boxMaker = {};

boxMaker.lorem = '';

boxMaker.loremLen = boxMaker.lorem.length;

boxMaker.makeBoxes = function() {
  var boxes = [],
      count = Math.random();

  for (var i=0; i < count; i++ ) {
    var box = document.createElement('div'),
        text = document.createTextNode("Tu");

    box.className = 'box col';
    box.appendChild( text );
    // add box DOM node to array of new elements
    boxes.push( box );
  }

  return boxes;
};

