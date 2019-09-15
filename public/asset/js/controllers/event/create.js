app.controller('EventCreateController', function ($scope, $cookies) {

    $scope.hide_create_form = false;

    $scope.step = 0;

    $scope.collisionDetected = false;

    $scope.slicesBlocks = [];

    $scope.canshow = true;

    $scope.currentBlock = null;

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
    $scope.blockBeforeToday = function (d) {
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
    $scope.blockStartBeforeToday = function (d) {
        let curtime = $scope.getCurrentDate();

        return curtime <= d;
    };

    /**
     *
     * @returns {Date}
     */
    $scope.getCurrentDate = function () {
        return new Date();
    };


    $scope.checkSelected = function (event) {
        $scope.collisionDetected = false;
        let selection = $scope.getSelection();
        console.log(selection);

        if (selection !== null && selection.anchorOffset !== selection.focusOffset) {
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
                content: selection.toString(),
                start: s,
                end: e,
            };
            console.log($scope.currentBlock);
            $scope.checkBlock();
            $scope.showPopover(event);
        } else {
            $scope.popover = false;
        }
    };


    $scope.checkBlock = function () {
        let points = [];
        points.push({x: $scope.currentBlock.start, left: true});
        points.push({x: $scope.currentBlock.end, left: false});

        console.log($scope.slicesBlocks);
        angular.forEach($scope.slicesBlocks, function (bl) {
            points.push({x: bl.start, left: true});
            points.push({x: bl.end, left: false});
        });

        points.sort(function (a, b) {
            return a.x - b.x;
        });

        let numLayers = 0;
        for (let p of points) {
            if (p.left) {
                numLayers++;
            } else {
                numLayers--;
            }
            if (numLayers > 1) {
                $scope.collisionDetected = true;
                break;
            }
        }
    };

    $( document ).keydown(function(e) {
        if(e.which === 17) {
            console.log('d');

            if ($scope.canshow){
                $scope.updateHighLight();
            }
            $scope.canshow = false;
        }
    });

    $( document ).keyup(function(e) {
        if(e.which === 17) {
            console.log('u');
            $scope.canshow = true;
            $scope.disableHighLight();
        }
    });

    String.prototype.splice = function (idx, rem, str) {
        return this.slice(0, idx) + str + this.slice(idx + Math.abs(rem));
    };

    $scope.disableHighLight = function() {
        console.log($scope.event.document);
        $scope.event.document = $scope.documentCopy.toString();
        angular.element(document.querySelector("#docText")).html($scope.documentCopy);
    };

    $scope.updateHighLight = function() {
        $scope.slicesBlocks.sort(function (a, b) {
            return -(a.start - b.start);
        });


        console.log($scope.slicesBlocks);
        for(let block of $scope.slicesBlocks) {
            let cont = $scope.event.document.toString().splice(block.end, 0, "</span>").splice(block.start, 0, "<span style=\"background-color: #00FF00\">");
            $scope.event.document = cont;
            angular.element(document.querySelector("#docText")).html(cont);
        }
   };

    $scope.addBlock = function () {
        if ($scope.currentBlock !== null && !$scope.collisionDetected) {
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

    $scope.getSelection = function () {
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
    $scope.showPopover = function (mouseEvent) {
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
    $scope.checkEvent = function (event) {
        var flag = true;

        angular.forEach(event.users, function (item) {
            if ($scope.isEmpty(item.email)) {
                flag = false;
            }
        });

        console.log(event);
        if ($scope.isEmpty(event.name) || $scope.isEmpty(event.document) || $scope.isEmpty(event.startdate)) {
            flag = false;
        }

        if (event.type == 0 && $scope.isEmpty(event.enddate)) {
            flag = false;
        }

        return flag;
    };

    $scope.startBlockSlicing = function () {
        $scope.documentCopy = $scope.event.document.toString();

        $scope.apiCall('event', 'POST', {
            name: $scope.event.name,
            arbiter: $scope.getCookie('user_id'),
            type: $scope.event.type,
            endtime: $scope.event.enddate,
            starttime: $scope.event.startdate,
        }, function (result) {
            if (result.data.id !== undefined) {
                $scope.event.id = result.data.id;
            }
            angular.forEach(event.users, function (item) {
                if (!$scope.isEmpty(item.email)) {
                    item.link = 'http://xvote/login/byLink/' + item.email + '/' + $scope.event.id;
                }
            });

            console.log(result);
        });

        $scope.hide_create_form = true;
        $scope.step = 1;
    };
});