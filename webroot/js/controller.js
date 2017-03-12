var app = angular.module('worklog', ['MyService']);
app.controller('loginController', ['AppService', '$scope', '$http', function(AppService, $scope, $http) {

    $scope.msg = 'Hello, AngularJS!!!!';
    $scope.email_flg = false;
    $scope.password_flg = false;
    $scope.msg_flg = false;

    $scope.check = function() {
        alert(AppService.get_storage('user_login'));
    }

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
                // 2成功時の処理（ページにあいさつメッセージを反映）
                function onSuccess(data) {
                    $scope.result = data;
                    AppService.set_storage('user_login', 'OK');
                    location.href = "top.html";
                },
                // 3失敗時の処理（ページにエラーメッセージを反映）
                function onError(data) {
                    $scope.msg = '通信失敗！';
                    $scope.msg_flg = true;
                    AppService.set_storage('user_login', 'ERROR');
                }
            );
        }
    }

}]);