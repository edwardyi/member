<!DOCTYPE html>
<html ng-app>
  <head>
    <meta charset="utf-8">  
    <title>邊學AngularJS邊做Todo List </title>
    <script type="text/javascript" src="http://code.angularjs.org/angular-1.0.1.min.js"></script>
    <script type="text/javascript" src="http://code.angularjs.org/angular-1.0.1.min.js"></script>
    <script type="text/javascript" >
      // function TodoCrtl($scope) {
      //   $scope.newItem = "";
      //   $scope.todoList = [{ label: '買牛奶' }, { label: '繳電話費' }];
      // }
      function TodoCrtl($scope) {
        $scope.newItem = '';
        $scope.todoList = [{ label: '買牛奶' }, { label: '繳電話費' }];
        $scope.addItem = function() {
             if(this.newItem) {
                 this.todoList.push({label:this.newItem});
                 this.newItem = "";
             }    
        }
      }

    </script>
  </head>
  <body ng-controller="TodoCrtl">

      <h1>Todo List</h1>
      <form  ng-submit="addItem()">
        <input type="text" ng-model="newItem" name="newItem" />
        <input type="submit" id="submit" value="新增" />
      </form>
      <ul>
        <li ng-repeat="item in todoList">{{item.label}}</li>  
      </ul>


      <h1>Hello World</h1>
  <p>AngularJs say hello to {{yourName || 'everyone'}}!</p>
      <label>輸入你的姓名，Angular會跟你打招呼</label>
      <input type="text" ng-model="yourName">
  </body>
</html>
