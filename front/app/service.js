app.service('hexafy', function($http) {


    this.getData = function () {
        var promise =  $http.get('http://localhost:8001/api/viewcontact');
        return promise;
    };


    this.addData_sevice = function (emp) {
        return $http({
            method: 'POST',
            url: 'http://localhost:8001/api/insertdata',
            data: {
                fname: emp["fname"],
                lname: emp["lname"],
                email: emp["email"],
                telno: emp["telno"]
            }
        });
    };

    this.deleteData_sevice = function (id) {
        return $http({
            method: 'POST',
            url: 'http://localhost:8001/api/deletedata',
            data: {
                id: id
            }
        });
    };

    this.updateData_sevice = function (id,fname,lname,email,telno) {
        return $http({
            method: 'POST',
            url: 'http://localhost:8001/api/updatedata',
            data: {
                id: id,
                fname: fname,
                lname: lname,
                email: email,
                telno: telno
            }
        });
    }
});
