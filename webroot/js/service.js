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
        	this.set_storage('user_login', '');
	        location.href = "logout.html";
        };

        // 登録した工数情報を取得
        this.get_worklog = function(user_id, date) {
            console.log("get_worklog");
            $http({
                method: 'GET',
                url: '/worklog',
                params: {
                    user_id: user_id,
                    date: date,
                }
            })
            .then(
                // 成功時の処理
                function onSuccess(data) {
                    console.log(data);
                },
                // 失敗時の処理
                function onError(data) {
                }
            );
        };


}]);