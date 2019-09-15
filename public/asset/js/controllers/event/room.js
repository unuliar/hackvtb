app.controller('RoomController', function($scope, $cookies){
    setInterval(()=>$scope.getData(), 500);
    $scope.event_data = null;

    $scope.formatDate = function(date) {
        let tdate = moment(date);

        return tdate.format('DD.MM.YYYY HH:mm');
    };

    $scope.checkOutcoming = function(message) {
      return message.user.id == $cookies.get('user_id');
    };

    $scope.getData = function() {
        $scope.apiCall('event', 'GET', {
            id: event_id
        }, function(result) {
            $scope.event_data = result.data;
        })

};
    $scope.sendMessage = function(message) {
        $scope.apiCall('message', 'POST', {
            content: message,
            time: moment().toISOString(),
            user: parseInt($cookies.get('user_id')),
            event: event_id
        })
    }
});