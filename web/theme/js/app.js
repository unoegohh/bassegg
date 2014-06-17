var myApp = angular.module('myApp',['angular-growl','ngAnimate']);

myApp.config(function($interpolateProvider,$httpProvider){
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
    // Используем x-www-form-urlencoded Content-Type
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

    // Переопределяем дефолтный transformRequest в $http-сервисе
    $httpProvider.defaults.transformRequest = [function(data)
    {
        /**
         * рабочая лошадка; преобразует объект в x-www-form-urlencoded строку.
         * @param {Object} obj
         * @return {String}
         */
        var param = function(obj)
        {
            var query = '';
            var name, value, fullSubName, subValue, innerObj, i;

            for(name in obj)
            {
                value = obj[name];

                if(value instanceof Array)
                {
                    for(i=0; i<value.length; ++i)
                    {
                        subValue = value[i];
                        fullSubName = name + '[' + i + ']';
                        innerObj = {};
                        innerObj[fullSubName] = subValue;
                        query += param(innerObj) + '&';
                    }
                }
                else if(value instanceof Object)
                {
                    for(subName in value)
                    {
                        subValue = value[subName];
                        fullSubName = name + '[' + subName + ']';
                        innerObj = {};
                        innerObj[fullSubName] = subValue;
                        query += param(innerObj) + '&';
                    }
                }
                else if(value !== undefined && value !== null)
                {
                    query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
                }
            }

            return query.length ? query.substr(0, query.length - 1) : query;
        };

        return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
    }];
});

myApp.controller('DefaultController', ['$scope', '$location','$http','growl', function($scope,$location,$http, growl) {
    $scope.cart = scart;
    $scope.totalCart = 0;
    $scope.itemsInCart = 0;
    $scope.count = 1;
    $scope.payment_type = "";
    $scope.cartinstring =JSON.stringify($scope.cart);

    $scope.redirectPayment = function(){
      if($scope.payment_type == 1){
          $scope.updateCart();

          changeLocation('/order/cash', true);
      }
    };

    function changeLocation(url, forceReload) {
        $scope = $scope || angular.element(document).scope();
        if(forceReload || $scope.$$phase) {
            window.location = url;
        }
        else {
            //only use this if you want to replace the history stack
            //$location.path(url).replace();

            //this this if you want to change the URL and add it to the history stack
            $location.path(url);
            $scope.$apply();
        }
    };

    function totalCart()
    {
        var total = 0;
        var key;
        for (key in $scope.cart.items) {
            total =parseInt(total +( parseInt($scope.cart.items[key].price) * parseInt($scope.cart.items[key].count)));
        }
        return total;
    }
    function itemsInCart()
    {
        var total = 0;
        var key;
        for (key in $scope.cart.items) {
            total =parseInt(total + parseInt($scope.cart.items[key].count));
        }
        return total;
    }
    $scope.updateCart = function()
    {
        $scope.itemsInCart = itemsInCart();
        $scope.totalCart = totalCart();
        $http({
            method: 'POST',
            url: '/cart/update',
            data: {data: JSON.stringify($scope.cart)},
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        });
    }
    $scope.addToCart = function(id, price,count,name,img)
    {

        var found = false;
        for(var i = 0;i <= $scope.cart.items.length; i++){
            if(typeof($scope.cart.items[i]) != "undefined"){

                if($scope.cart.items[i].id == id){

                    $scope.cart.items[i].count +=parseInt(count);
                    found = true;
                }
            }
        }
        if(!found){
            $scope.cart.items.push({count:parseInt(count), price:price, name:name, image:img, id: id})

        }
        $scope.updateCart();
        growl.addInfoMessage("Товар добавлен в корзину", {ttl: 2000});

    };
    $scope.upCount = function(item){
        item.count++;
        $scope.updateCart();
    };
    $scope.downCount = function(item){
        if(item.count != 1){
            item.count--;
            $scope.updateCart();
        }
    };

    $scope.upCountCart = function(item){
        $scope.count++
    };
    $scope.downCountCart = function(item){
        if(item != 1){
            $scope.count--;
        }
    };
    $scope.deleteOne = function ( idx ) {
        $scope.cart.items.splice(idx, 1);
        $scope.updateCart();

    };
    $scope.updateCart();

}]);