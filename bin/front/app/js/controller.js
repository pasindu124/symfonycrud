var app = angular.module("mainApp",[]);


app.controller("CRUDController", function ($scope,hexafy) {
    $scope.title = "pas";
    $scope.getData = function () {
        var promise = hexafy.getData();

        promise.then(
            function(payload) {
                $scope.Emplist = [];
                $scope.Emplist = payload.data;
                return $scope.Emplist;

            });
    };


    $scope.addData = function () {
        var emp = {

            "fname": $scope.fname,
            "lname": $scope.lname,
            "email": $scope.email,
            "telno": $scope.telno
        };

        hexafy.addData_sevice(emp).then(function() {
            $scope.clearModel();
            $scope.getData();
            $scope.addMsg = "Contact added successfully !";
        });

    };

    $scope.deleteData = function (emp) {
        var id = emp.id;
        hexafy.deleteData_sevice(id).then(function() {
            $scope.clearModel();
            $scope.getData();
            $scope.deleteMsg = "Contact deleted successfully !";
        });
    };

    $scope.bindSelectData = function (Emp) {
        $scope.id=Emp.id;
        $scope.fname = Emp.fname;
        $scope.lname =Emp.lname;
        $scope.email =Emp.email;
        $scope.telno =Emp.telno;
    };

    $scope.updateData = function () {
        hexafy.updateData_sevice($scope.id,$scope.fname,$scope.lname,$scope.email,$scope.telno).then(function() {
            $scope.clearModel();
            $scope.getData();

        });
    };

    $scope.clearModel = function () {
        $scope.id=0;
        $scope.fname = "";
        $scope.lname = "";
        $scope.email = "";
        $scope.telno = "";

        $scope.addMsg = null;
        $scope.updateMsg = null;
        $scope.deleteMsg = null;
    }

    $scope.reverseString = function () {
      return "pas";
    };

    $scope.getData();



});
