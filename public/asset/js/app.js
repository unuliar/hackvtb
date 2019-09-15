var app = angular.module('xvote-app',["ngQuickDate","ui.bootstrap", "ngCookies"]);

app.config(function($interpolateProvider, $sceProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
    $sceProvider.enabled(false);
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
            method: method,
            params: data,
            url: '/api/' + func
        }).then(successCallback).catch(function(error){
            console.log('Ошибка при запросе: ');
            console.log(error);
        });
    };

    $rootScope.getCookie = function (name) {
        var value = "; " + document.cookie;
        var parts = value.split("; " + name + "=");
        if (parts.length == 2) return parts.pop().split(";").shift();
    };

    /**
     *
     * @param variable
     * @returns {boolean}
     */
    $rootScope.isEmpty = function(variable) {
        return variable == null || variable === '';
    };

    /**
     *
     * @param name
     * @returns {string}
     */
    $rootScope.getCookie = function (name) {
        var value = "; " + document.cookie;
        var parts = value.split("; " + name + "=");
        if (parts.length == 2) return parts.pop().split(";").shift();
    }
});

