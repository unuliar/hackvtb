app.controller('EventCreateController', function($scope) {

    $scope.hide_create_form = false;

    $scope.step = 0;

    $scope.collisionDetected = false;

    $scope.slicesBlocks = [];

    $scope.currentBlock = 0;

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


    $scope.checkSelected = function(event) {
        $scope.collisionDetected = false;
        let selection = $scope.getSelection();

        if(selection !== null && selection.anchorOffset !== selection.focusOffset) {
            let s = selection.baseOffset;
            let e = selection.focusOffset;
            if (s < e) {
                s = selection.baseOffset;
                e = selection.focusOffset;
            } else {
                s = selection.focusOffset;
                e = selection.baseOffset;
            }
            $scope.currentBlock = {
              start: s,
              end: e,
                content: selection.toString(),
            };
            console.log($scope.currentBlock);
            $scope.checkBlock();
            $scope.showPopover(event);
        } else {
            $scope.popover = false;
        }
    };


    $scope.checkBlock = function() {
        let points = [];
        points.push({x: $scope.currentBlock.start, left: true});
        points.push({x: $scope.currentBlock.end, left: false});
        for(let bl of $scope.slicesBlocks) {
            points.push({x: bl.start, left: true});
            points.push({x: bl.end, left: false});
        }
        points.sort(function(a, b) {
            return a.x - b.x;
        });

        numLayers = 0;
        for(let p of points) {
            if(p.left) {
                numLayers++;
            } else {
                numLayers--;
            }
            if(numLayers > 1) {
                $scope.collisionDetected = true;
                break;
            }
        }
    };

    String.prototype.splice = function(idx, rem, str) {
        return this.slice(0, idx) + str + this.slice(idx + Math.abs(rem));
    };

    $scope.addBlock = function() {
        if($scope.currentBlock !== null && !$scope.collisionDetected) {
            $scope.slicesBlocks.push($scope.currentBlock);
            $scope.apiCall('block', 'POST', {
                event: $scope.event.id,
                content: $scope.currentBlock.content,
                placeholder: $scope.currentBlock.start + ":" + $scope.currentBlock.end,
                user: $scope.getCookie('user_id'),
            }, function (result) {
                console.log(result);
            })
        }
    };

    $scope.getSelection = function() {
        let selection = null;
        if (window.getSelection) {
            selection = window.getSelection();
        } else if (document.selection && document.selection.type != "Control") {
            selection = document.selection;
        }
        return selection;
    };

    $scope.popover = false;
    $scope.coord = {};
    $scope.x = 0;
    $scope.y = 0;

    //Method to show popover
    $scope.showPopover = function(mouseEvent) {
        $scope.popover = true;
        $scope.x = mouseEvent.pageX + 'px';
        $scope.y = mouseEvent.pageY + 'px';
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
        if($scope.currentBlock !== null && !$scope.collisionDetected) {
            $scope.slicesBlocks.push($scope.currentBlock);
            $scope.apiCall('event', 'POST', {
                name: $scope.event.name,
                arbiter: $scope.getCookie('user_id'),
                type: $scope.event.type,
                endtime: $scope.event.enddate,
                starttime: $scope.event.startdate,
            }, function (result) {
                if(result.data.id  !== undefined) {
                    $scope.event.id = result.data.id;
                }
                console.log(result);
            })
        }

        $scope.hide_create_form = true;
        $scope.step = 1;
    };
});