upbase 0.1.0
======

This is a CSS helper library to assist in all kinds of common front-end tasks. It's not a "framework" like Boilerplate, but is meant to support a designer coding their own front end and make common tasks easier and more robust. 


### Installation (assuming you have Bower and Compass installed):
1. From the root of your project, install the Upbase repo using `bower install git@github.com:Upstatement/upbase.git`
2. Copy the `config.rb` file to your root from the `config` folder inside the `upbase` folder
3. Verify that the paths in `config.rb` match the paths you'd like to watch for your project
4. Run `compass watch` on the root of your directory
5. Verify that the `css` and `sass` directories have been created
6. Navigate to your `sass` folder and create a file like `style.scss`. 
7. Add the line `@import "base";` to the top of the `style.scss` file. This connects the files in `sass` to the components in upbase. 
8. You're good! Sass away and make sure the output is showing up in `css` or wherever you told it to put the compiled output. 

### Dependencies
This library requires Compass or a compiler like LiveReload to watch and compile the scss. Optimal installation requires Bower. 

### Yeoman usage
The primary usage for this right now is to deploy it with Yeoman using the Upbase generator found here: https://github.com/Upstatement/generator-upbase/

## Directory Structure
Here's a guide to what lives where, and how to use it:

+--`README.MD` // you're reading it!    
|   
+--`bower.json` // tells bower to grab it   
|   
+--`/config/`   
| |   
| +--`config.rb` // this is the config file for compass. Move this to the root of your project.   
|   
+--`/components` // Where all the Upbase scss files live   
| |   
| +--`_base.scss`        //    Imports all the junk   
| +--`_layout.scss`      //    Helpers for layout including Media-grid and cols()   
| +--`_mixins.scss`      //    Mixins for various things like SVG   
| +--`_normalize.scss`   //    Not sure   
| +--`_reset.scss`       //    Resets CSS    
| +--`_variables.scss`   //    Variables for things   
|   
+--`/js` // Where all the Upbase scss files live   
  |    
  +--`upbase.js` // JS helpers for compatibility in older browsers and stuff like `.even` `.odd` counting.    
