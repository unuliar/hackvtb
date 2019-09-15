app.controller('ProtocolController', function($scope) {
    $scope.event = null;

    $scope.getEvent = function() {
      $scope.apiCall('event', 'GET', {
          id: event_id
      },function(result) {
          $scope.event = result.data;
      });
    };
});
