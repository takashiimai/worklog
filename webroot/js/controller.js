var app = angular.module('worklog', ['MyService']);

app.controller('loginController', ['AppService', '$scope', '$http', function(AppService, $scope, $http) {

    $scope.msg = '';
    $scope.email_flg = false;
    $scope.password_flg = false;
    $scope.message_flg = false;

    $scope.check = function() {
        alert(AppService.get_storage('user_login'));
    }

    // フォーム送信処理
    $scope.onsubmit = function() {
        // メールアドレスチェック
        if (!$scope.email) $scope.email_flg = true;
        else $scope.email_flg = false;

        // パスワードチェック
        if (!$scope.password) $scope.password_flg = true;
        else $scope.password_flg = false;

        // ログインチェック
        if (!$scope.password_flg && !$scope.password_flg) {
            $http({
                method: 'GET',
                url: '/login',
                params: {
                    email: $scope.email,
                    password: $scope.password,
                }
            })
            .then(
                // 成功時の処理
                function onSuccess(data) {
                    console.log(data);
                    if (data['data'].length == 0) {
                        $scope.message = 'メールアドレスまたはパスワードが違います。';
                        $scope.message_flg = true;
                    } else {
                        $scope.message = 'ログイン成功しました。';
                        $scope.message_flg = true;
                        AppService.set_storage('user_login', data['data']);
                        location.href = "top.html";
                    }
                },
                // 失敗時の処理
                function onError(data) {
                    $scope.message = 'サーバーとの通信に失敗しました。';
                    $scope.message_flg = true;
                    AppService.set_storage('user_login', '');
                }
            );
        }
    }

}]);


app.controller('topController', ['AppService', '$scope', '$http', function(AppService, $scope, $http) {

    var user = AppService.get_storage('user_login');
    if (user == null) {
        location.href = "login.html";
    } else {
        $scope.user = user;
    }

    // フォーム送信処理
    $scope.logout = function() {
        AppService.logout();
    }
}]);
