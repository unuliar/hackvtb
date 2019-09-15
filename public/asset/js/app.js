var app = angular.module('xvote-app',["ngQuickDate","ui.bootstrap"]);

app.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
});

app.run(function($rootScope, $http){

    /**
     * Вызов API backend
     *
     * @param func
     * @param method
     * @param data
     * @param successCallback
     */
    $rootScope.apiCall = function(func, method, data, successCallback) {
        $http({
            method: method.toUpperCase(),
            data: data,
            url: '/api/' + func
        }).then(successCallback).catch(function(error){
            console.log('Ошибка при запросе: ');
            console.log(error);
        });
    };

    /**
     *
     * @param variable
     * @returns {boolean}
     */
    $rootScope.isEmpty = function(variable) {
        return variable == null || variable === '';
    };

});

