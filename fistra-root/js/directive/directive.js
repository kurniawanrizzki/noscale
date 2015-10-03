angular.module('directives', [])

.directive('map', function() {
  return {
    restrict: 'E',
    scope: {
      onCreate: '&'
    },
    link: function ($scope, $element, $attr) {
      var mapOptions = {
        center: new google.maps.LatLng(-7.051315, 110.441141),
        zoom: 16,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      };

      var mapAgen = new google.maps.Map($element[0], mapOptions);
      
      function initialize() {
        $scope.onCreate({map: mapAgen});
        // Stop the side bar from dragging when mousedown/tapdown on the map
        google.maps.event.addDomListener($element[0], 'mousedown', function (e) {
          e.preventDefault();
          return false;
        });
      }

      if (document.readyState === "complete") {
        initialize();
      } else {
        google.maps.event.addDomListener(window, 'load', initialize);
      }
    }
  }
});

