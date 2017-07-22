//sidenav order li

$.fn.ignore = function(sel){
  return this.clone().find(sel||">*").remove().end();
};

var items = $('#mobile-sideNav li .order').get();
items.sort(function(a,b){
  var keyA = $(a).ignore("i").text();
  var keyB = $(b).ignore("i").text();

  if (keyA < keyB) return -1;
  if (keyA > keyB) return 1;
  return 0;
});
var ul = $('#mobile-sideNav');
$.each(items, function(i, li){
  ul.append(li);
});
