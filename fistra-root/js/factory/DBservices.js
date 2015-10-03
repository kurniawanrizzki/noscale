angular.module('DBServices',['configDB'])

.factory('DB',function($q,$ionicPlatform,$cordovaSQLite,DBHelper){
	var self = this;
	self.db = null;

	//Inisiasi Database dan tables
	self.init = function(){
		self.db = window.openDatabase(DBHelper.name,'1.0','database',-1);
		angular.forEach(DBHelper.tables, function(table){
			var columns = [];

			angular.forEach(table.columns,function(column){
				columns.push(column.name+' '+column.type);
			});

			//var query = 'DROP TABLE IF EXISTS '+table.name;
			var query = 'CREATE TABLE IF NOT EXISTS '+table.name+' ('+columns.join(',')+')';
			$cordovaSQLite.execute(self.db,query);

			
		},function(error){
			console.log("TERJADI ERROR PADA init()-->"+error);
		});
		

		// self.db = $cordovaSQLite.openDB("FISTRA_DB");

		// window.plugins.sqlDB.copy("FISTRA_DB", function() {
  //           self.db = $cordovaSQLite.openDB("FISTRA_DB");
            
  //       }, function(error) {
  //           console.error("DATABASE EXIST!! " + error);
  //           self.db = $cordovaSQLite.openDB("FISTRA_DB");
  //       });

	};
	//end inisiasi database

	//method query asinkron
	self.query = function (query, parameters) {
		parameters = parameters || [];
		var q = $q.defer();

		$ionicPlatform.ready(function () {
			$cordovaSQLite.execute(self.db, query, parameters).then(function (result) {
			    q.resolve(result);
			}, function (error) {
			    console.log('TERJADI ERROR DI QUERY'+error);
			    q.reject(error);
			});
		});
	  	return q.promise;
	};
	//end query
	
	//method to fetch all data dalam query
	self.fetchAll = function(result){
		var data = [];

		for(var i = 0;i < result.rows.length;i++){
			data.push(result.rows.item(i));
		}
		return data;
	};
	//end methode to fetch all

	//method pengambiln data berdasarkan id
	self.fetch = function(result){
		var data = null;
    	data = angular.copy(result.rows.item(0));
    	return data;
	};
	//end method pengambilan dara berdasarkan id

	return self;
});