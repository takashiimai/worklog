var app = angular.module('worklog', ['MyService']);

// 共通コントローラ
app.controller('baseController', ['AppService', '$scope', '$http', function(AppService, $scope, $http) {

	// ログインチェック処理
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
						window.setTimeout('location.href = "top.html";', 2000)
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
	if ($scope.regist_date == undefined || $scope.regist_date == '') {
		var obj = new Date();
		var year = obj.getFullYear();
		var month = "00" + (obj.getMonth() + 1);
		var day = "00" + obj.getDate();
		$scope.regist_date = year + '-' + month.substr(-2) + '-' + day.substr(-2);
	}
}]);

