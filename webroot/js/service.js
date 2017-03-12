angular.module('MyService', [])
    .service('AppService', ['$log', '$http', function($log, $http) {

        // ストレージにデータを保存
        this.set_storage = function(key, value) {
            window.localStorage.setItem(key, value);
        };

        // ストレージからデータを取得
        this.get_storage = function(key) {
            return window.localStorage.getItem(key);
        };

}]);