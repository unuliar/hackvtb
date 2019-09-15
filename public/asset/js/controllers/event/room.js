app.controller('RoomController', function($scope, $cookies){
    setInterval(()=>$scope.getData(), 1000);
    $scope.event_data = null;

    $scope.block = null;

    $scope.versions = null;

    $scope.formatDate = function(date) {
        let tdate = moment(date);

        return tdate.format('DD.MM.YYYY HH:mm');
    };

    $scope.checkOut= function(message) {
      return message.user.id == $cookies.get('user_id');
    };

    $scope.notVersion = function(block) {
        return block.parent == null;
    };

    $scope.getData = function() {
        $scope.apiCall('event', 'GET', {
            id: event_id
        }, function(result) {
            $scope.event_data = result.data;
        })

    };

    $scope.openVersions = function(id) {
        location.href = '/event/versions/' + id;
    };

    $scope.sendMessage = function(message) {
        $scope.apiCall('message', 'POST', {
            content: message,
            time: moment().toISOString(),
            user: parseInt($cookies.get('user_id')),
            event: event_id
        })
    };

    $scope.getBlock = function () {
        $scope.apiCall('block', 'GET', {
            id: block_id
        }, function(result){
           $scope.block = result.data;
        });
    };

    $scope.showAddversion = function(object) {
        object.show_add = true;
    };

    $scope.addVariant = function() {
        $scope.apiCall('block','POST', {
            content: $scope.block[0].content,
            parent: $scope.block[0].id,
            placeholder: $scope.block[0].placeholder,
            event: $scope.block[0].event.id,
            user: $cookies.get('user_id')
        });

        window.location.href = '/event/room/' + $scope.block[0].event.id
    };

    $scope.votePlus = function(id, event) {
        $scope.apiCall('vote', 'POST', {
            value: 1,
            user: $cookies.get('user_id'),
            block: id
        }, function(result) {
            $scope.apiCall('message', 'POST', {
                content: 'Я выбрал ',
                time: moment().toISOString(),
                user: parseInt($cookies.get('user_id')),
                event: event.event.id
            });

            location.href = "/event/room/" + event.event.id;
        });
    };

    $scope.voteMinus = function(id,event) {
        $scope.apiCall('vote', 'POST', {
            value: 0,
            user: $cookies.get('user_id'),
            block: id
        }, function(result) {
            location.href = "/event/room/" + event.event.id;
        });
    };

    $scope.countPlusVotes = function (votes) {
        let count = 0;

        console.log(votes)
        angular.forEach(votes, function(item){
            if(item.value == 1) {
                count++;
            }
        });

        return count;
    };

    $scope.countMinusVotes = function (votes) {
        let count = 0;

        angular.forEach(votes, function(item){
            if(item.value == 0) {
                count++;
            }
        });

        return count;
    };
});