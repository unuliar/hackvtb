app.controller('EventCreateController', function($scope) {

    $scope.hide_create_form = false;

    $scope.step = 0;

    $scope.step_headings = [
        "Шаг 1: Первоначальная настройка голосования",
        "Шаг 2: Разделение документа на блоки",
        ];

    $scope.help = [
        "",
        "Выделите кусок текста который вы хотите выделить в отдельный блок для дальнейшнего обсуждения"
    ];

    /**
     * Фильтр даты
     *
     * @param d
     * @returns {boolean}
     */
    $scope.blockBeforeToday = function(d) {
        let curtime = $scope.getCurrentDate();
        let starttime = $scope.event.startdate;

        return curtime <= d || starttime <= d;
    };

    /**
     * Фильтр даты
     *
     * @param d
     * @returns {boolean}
     */
    $scope.blockStartBeforeToday = function(d) {
        let curtime = $scope.getCurrentDate();

        return curtime <= d;
    };

    /**
     *
     * @returns {Date}
     */
    $scope.getCurrentDate = function() {
        return new Date();
    };

    /**
     * Проверка введенных данных
     *
     * @param event
     * @returns {boolean}
     */
    $scope.checkEvent = function(event) {
        var flag = true;

        angular.forEach(event.users, function(item) {
            if($scope.isEmpty(item.email)) {
                flag = false;
            }
        });

        console.log(event);
        if($scope.isEmpty(event.name) || $scope.isEmpty(event.document) || $scope.isEmpty(event.startdate)) {
            flag = false;
        }

        if(event.type == 0 && $scope.isEmpty(event.enddate)) {
            flag = false;
        }

        return flag;
    };

    $scope.startBlockSlicing = function () {
        $scope.hide_create_form = true;
        $scope.step = 1;
    };
});