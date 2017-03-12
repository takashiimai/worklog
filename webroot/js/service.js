angular.module('MyService', [])
    .service('AppService', ['$log', '$http', function($log, $http) {

        // ストレージにデータを保存
        this.set_storage = function(key, value) {
            window.sessionStorage.setItem(key, JSON.stringify(value));
        };

        // ストレージからデータを取得
        this.get_storage = function(key) {
            return JSON.parse(window.sessionStorage.getItem(key));
        };

        this.logout = function() {
            alert("ログアウト");
        };
}]);