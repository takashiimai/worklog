var app = angular.module('worklog', ['MyService']);
var user;

// 共通コントローラ
app.controller('baseController', ['AppService', '$scope', '$http', function(AppService, $scope, $http) {

	// ログインチェック処理
    user = AppService.get_storage('user_login');
    if (user == null || user == "") {
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

    $scope.worklog_types = [
        {name:'開発', value:'開発'},
        {name:'運用', value:'運用'},
        {name:'営業', value:'営業'},
    ];

	if ($scope.regist_date == undefined || $scope.regist_date == '') {
		var obj = new Date();
		var year = obj.getFullYear();
		var month = "00" + (obj.getMonth() + 1);
		var day = "00" + obj.getDate();
		$scope.regist_date = year + '-' + month.substr(-2) + '-' + day.substr(-2);
//        $scope.worklogs = AppService.get_worklog(user.id, $scope.regist_date);
        get_worklog(user.id, $scope.regist_date);
	}


    // 追加
    $scope.add_row = function(idx) {
        $scope.worklogs[idx+1] = {};
    };

    // 削除
    $scope.del_row = function(idx) {
        $scope.worklogs.splice(idx, 1);
    };

    // 工数送信
    $scope.submit_worklog = function() {
        console.log("=== submit_worklog ===");
        $http({
            method: 'POST',
            url: '/worklog/put/?user_id=' + user.id + '&date=' + $scope.regist_date,
            data: $scope.worklogs,
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


    // 日付の変更をウォッチ
    $scope.$watch('regist_date', function(newValue, oldValue, scope) {
        if(angular.equals(newValue, oldValue)) {
            scope.result = 'ok';
        } else {
//            $scope.worklogs = AppService.get_worklog(user.id, $scope.regist_date);
          get_worklog(user.id, $scope.regist_date);
        }
    });

    // 登録した工数情報を取得
    function get_worklog(user_id, date) {
        console.log("=== get_worklog ===");
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
                var initSize = 3;
                var work  = new Array();
                for (var i = 0; i < initSize; i++){
                    work[i] = {};
                }

                $scope.worklogs = data.data.concat(work);
            },
            // 失敗時の処理
            function onError(data) {
            }
        );
    };

}]);

