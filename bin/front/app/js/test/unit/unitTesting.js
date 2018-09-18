describe('Test our AngularJS appilication', function() {
    describe('Testing CRUDController JS', function() {

        beforeEach(module('mainApp'));
        var scope ={} ;
        var ctrl;
        beforeEach(
            inject(function ($controller) {
                ctrl=$controller('CRUDController',{$scope:scope})
            })
        );


        it('has a dummy spec to test 2 + 2', function() {

            expect(scope.title).toBeDefined();
            expect(2+2).toEqual(4);
        });

        it('It increse the length of emp list', function() {
            //var beforelength = scope.Emplist.length;
            expect(scope.title).toBeDefined();
            expect(2+2).toEqual(4);
        });
    });




    describe('Testing Service Hexafy JS', function() {

        describe('hexafy', function () {
            var hexafy, httpBackend;
            beforeEach(function () {

                module('mainApp');

                inject(function ($httpBackend, _hexafy_) {
                    hexafy = _hexafy_;
                    httpBackend = $httpBackend;
                });
            });

            afterEach(function () {
                httpBackend.verifyNoOutstandingExpectation();
                httpBackend.verifyNoOutstandingRequest();
            });





            it('Check get data function', function () {
                httpBackend.expectGET("http://localhost:8001/api/viewcontact")
                    .respond(200, {
                        status: "success"
                    });

                var returnedPromise = hexafy.getData();

                returnedPromise.then(function (response) {
                    expect(response.data.status).toEqual('success');
                });

                httpBackend.flush();
            });





            it('Check the insertdata function', function () {
                var emp = {

                    "fname": "Pasindu",
                    "lname": "Weerasinghe",
                    "email": "pasinduw@salpo.com",
                    "telno": 0712840598
                };
                httpBackend
                    .when('POST', 'http://localhost:8001/api/insertdata',emp)
                    .respond(200, {
                        status: "success"
                    });

                hexafy.addData_sevice(emp).then(function (response) {
                    expect(response.data.status).toEqual('success');
                });
                httpBackend.flush();
            });





            it('Check the delete data function', function () {
                httpBackend
                    .when('POST', 'http://localhost:8001/api/deletedata')
                    .respond(200, {
                        status: "success"
                    });

                hexafy.deleteData_sevice(4).then(function (response) {
                    expect(response.data.status).toEqual('success');
                });
                httpBackend.flush();
            });






            it('Check the update data function', function () {
                httpBackend
                    .when('POST', 'http://localhost:8001/api/updatedata')
                    .respond(200, {
                        status: "success"
                    });

                hexafy.updateData_sevice(4).then(function (response) {
                    expect(response.data.status).toEqual('success');
                });
                httpBackend.flush();
            });



        });

    });
});