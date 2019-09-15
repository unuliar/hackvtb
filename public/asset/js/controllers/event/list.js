app.controller('EventListController', function($scope) {

    $scope.eventList = [];

    $scope.parseStatus = function(status) {
        if(status == 0) {
            return "<h5 style=\"margin-top:9px;\" class=\"event-planned\"><i class=\"mdi mdi-progress-clock\"></i>Запланировано</h5>"
        }

        if(status == 1) {
            return "<h5 style=\"margin-top:9px;\" class=\"event-active\"><i class=\"mdi mdi-clock-start\"></i>Активен</h5>"
        }

        if(status == 2) {
            return "<h5 style=\"margin-top:9px;\" class=\"event-consideration\"><i class=\"mdi mdi-progress-alert\"></i>На рассмотрении</h5>"
        }

        if(status == 3) {
            return "<h5 style=\"margin-top:9px;\" class=\"event-finished\"><i class=\"mdi mdi-calendar-check\"></i>Завершён</h5>"
        }
    };

    $scope.formatDate = function(date) {
        let tdate = moment(date);

        return tdate.format('DD.MM.YYYY HH:mm');
    };

    $scope.getEventList = function() {
        $scope.apiCall('event', 'GET', {}, function(result){
           $scope.eventList = result.data;
        });
    };

    $scope.openProtocol = function(id) {
        location.href = '/event/protocol/' + id;
    };
});