'use strict';

//   ____ _   _ _     ____  
//  / ___| | | | |   |  _ \ 
// | |  _| | | | |   | |_) |
// | |_| | |_| | |___|  __/ 
//  \____|\___/|_____|_|    
//                        

 //  _   _  ___  ____  _____   ____   _    ____ _  __    _    ____ _____ ____  
 // | \ | |/ _ \|  _ \| ____| |  _ \ / \  / ___| |/ /   / \  / ___| ____/ ___| 
 // |  \| | | | | | | |  _|   | |_) / _ \| |   | ' /   / _ \| |  _|  _| \___ \ 
 // | |\  | |_| | |_| | |___  |  __/ ___ \ |___| . \  / ___ \ |_| | |___ ___) |
 // |_| \_|\___/|____/|_____| |_| /_/   \_\____|_|\_\/_/   \_\____|_____|____/ 
 //                                                                         

//***REQUIRE NODE PACKAGES***//

//***FOR GULP***//
var gulp = require('gulp');

//***FOR FILE/DIRECTORIES***//
//Logs the size of the file
var size = require('gulp-size');


//***FOR SASS***//
//Compiles .scss files using lib-sass for Node (no Ruby dependency)
var sass = require('gulp-sass');



//  _____  _    ____  _  ______  
// |_   _|/ \  / ___|| |/ / ___| 
//   | | / _ \ \___ \| ' /\___ \ 
//   | |/ ___ \ ___) | . \ ___) |
//   |_/_/   \_\____/|_|\_\____/ 
//

//Generic error handler for tasks
function handleError(err) {
  	console.error(err.toString());
  	this.emit('end');
}

//***** DEFAULT TASKS ******//

gulp.task('default', function () {
    //DO NOTHING BY DEFAULT
});


//Compiles SASS to dev/styles.css and dist/styles.css
gulp.task('styles', function () {
  	return gulp.src('sass/*.scss')
	    .pipe(sass({style: 'expanded'}))
	    .on('error', handleError)
	    .pipe(gulp.dest('sass'))
	    .pipe(size());
});


	