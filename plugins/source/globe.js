/**
 * A jQuery plugin boilerplate.
 * Author: Jonathan Nicol @f6design
 */
;(function($) {  
  // Change this to your plugin name. 
  var pluginName = 'globe';

  /**
   * Plugin object constructor.
   * Implements the Revealing Module Pattern.
   */
  function Plugin(element, options) {
    // References to DOM and jQuery versions of element.
    var mee = this

    var elem = element;
    var $elem = $(element);
    mee.elem = element;
    mee.$elem = $(element);

    // Extend default options with those supplied by user.
    options = $.extend(true, {}, $.fn[pluginName].options, options);
 
    /**
     * Initialize plugin.
     */
    function init() {
      // console.log("initializing globe")
      //clean up
      mee.$elem.empty()

      //create hotspot placeholders
      mee.hotspotTemplate = $('<div/>', {
          class: 'hotspot_marker',
      }).appendTo(mee.$elem);

      mee.overlay = $('<div/>', {
          class: 'overlay',
      }).appendTo(mee.$elem);      

      mee.hotspotDetails = $('<div/>', {
          id: 'hotspot_details',
      }).hide().appendTo(mee.overlay);

      mee.hotspotDetails_content = $('<div/>', {
          id: 'details_content',
      }).appendTo(mee.hotspotDetails);
      
      //setting up initial vars
      mee.targetRotation_x = 0
      mee.targetRotation_y = 0

      mee.hotspotsArr = [];
      hotspotDivsArr = [];
      // options = $.extend( {}, $.fn.doGlobe.options, options );

      windowDimensionX = mee.$elem.innerWidth();
      windowDimensionY = mee.$elem.innerHeight();
      
      // setup colorbox
      $.colorbox.settings.width = options.popWidth.val;
      $.colorbox.settings.height = options.popHeight.val;

      deleteOldAnimationHandler()
      refreshGlobe();
      animate();
      // me.animate(this);
      // me.targetRotation_x = 0;

    }
    
    function refreshGlobe () {
      // var me = this
      setup3D();
      generateContent()
      setupListeners()

      //used for testingpurposes
      if(options.debugMode.val===true){
        // console.log('settingUpDebug')
        setupDebug()
      }
    }

    function doZoomCam (wheelDelta) {
      // var me = this;
      // camera.fov = fov * zoom;
      //  camera.updateProjectionMatrix();
      

      wheelDelta*=-1
      var targetPos = wheelDelta * (camera.position.z / 7) + camera.position.z //+ event.wheelDeltaY/1.5

      var currScale = mee.scaleContainer.scale.z
      var targetScale = wheelDelta * (currScale / 3) + currScale;

      if(targetScale < options.globeMinScale.val)targetScale = options.globeMinScale.val
      if(targetScale > options.globeMaxScale.val)targetScale = options.globeMaxScale.val

      new TWEEN.Tween(mee.scaleContainer.scale)
        .to({x: targetScale,y: targetScale,z: targetScale}, 500)
        .easing(TWEEN.Easing.Quartic.EaseOut)
        .start();   

    }

    function deleteOldAnimationHandler () {
      try{cancelAnimationFrame(mee.animationHandler)}catch(err){}
    }

    function setup3D () {
      // var me = this
      //create and populate containers
      projector = new THREE.Projector()
      mee.globeContainer = new THREE.Object3D();
      mee.globeContainer.name = "globeContainer"
      mee.globeContainerParent = new THREE.Object3D();
      mee.globeContainerParent.name ='globeContainerParent'
      backPlateContainer = new THREE.Object3D();
      backPlateContainer.name ='backPlateContainer'
      mee.scaleContainer = new THREE.Object3D();
      mee.scaleContainer.name ='mee.scaleContainer'
      
      //scene
      mee.scene = new THREE.Scene();

      //camera
      camera = new THREE.OrthographicCamera( windowDimensionX / - 2, windowDimensionX / 2, windowDimensionY / 2, windowDimensionY / - 2, 2, 2000 );
      camera.position.x = options.camX.val;
      camera.position.y = options.camY.val;
      camera.position.z = options.camZ.val;
      camera.lookAt(new THREE.Vector3(options.cameraTargetX.val,options.cameraTargetY.val,options.cameraTargetZ.val))
      
      mee.scene.add( camera );

      //lighting
      ambient = new THREE.PointLight(options.ambientColor.val, options.ambientIntensity.val);
      ambient.position.set(options.ambientPosX.val, options.ambientPosY.val, options.ambientPosZ.val)
      mee.scaleContainer.add(ambient);
          
      headLamp = new THREE.PointLight(options.headLampColor.val, options.headLampIntensity.val);
      headLamp.position.set(options.headLampPosX.val, options.headLampPosY.val, options.headLampPosZ.val)
      headLamp.lookAt(mee.globeContainer.position)
      mee.scaleContainer.add(headLamp)

      //materials
      backPlateTexture = THREE.ImageUtils.loadTexture( options.assetPath.val + options.backPlateTexture.val )
      globeTexture = THREE.ImageUtils.loadTexture( options.assetPath.val + options.globeTexture.val )
      globeBump = THREE.ImageUtils.loadTexture(options.assetPath.val + options.globeBump.val)


      var globeMaterial = new THREE.MeshPhongMaterial( {  bumpScale:25, bumpMap: globeBump, map: globeTexture, ambient: 0x555555, color: 0xffffff, specular: 0x555555, shininess: options.globeShine.val} )
      backPlateMaterial = new THREE.MeshBasicMaterial( { map: backPlateTexture, color: 0xffffff, alphaTest:0, transparent:true } )

      //globeGeometry
      mee.globeGeo = new THREE.Mesh( new THREE.SphereGeometry( options.globeRadius.val, options.globeSegments.val, options.globeSegments.val ), globeMaterial );

      mee.globeGeo.position.x = 0;
      mee.globeGeo.position.y = 0;
      mee.globeGeo.position.z = 0;
      // mee.globeGeo.rotation.y = -90 * (Math.PI / 180);
      mee.globeGeo.name ="theGlobe"
      mee.globeContainer.add(mee.globeGeo);

      //backPlate
      var backPlateSize = 2*options.globeRadius.val+options.backPlateMargin.val*1
      backPlate = new THREE.Mesh(new THREE.PlaneGeometry(backPlateSize, backPlateSize ), backPlateMaterial )
      backPlateContainer.add(backPlate)
      // console.log(backPlateSize)

      //setup renderer
      if(!mee.renderer) mee.renderer = new THREE.WebGLRenderer({antialias:true, alpha:true } );
      mee.renderer.clear()
      
      mee.renderer.setSize( windowDimensionX, windowDimensionY );
      mee.renderer.autoClear = true;

      mee.$elem.append( mee.renderer.domElement );
      
      //add created containers to scene
      mee.scene.add(mee.scaleContainer)
      mee.scaleContainer.add(backPlateContainer);
      mee.scaleContainer.add(mee.globeContainerParent);
      mee.globeContainerParent.add(mee.globeContainer);
    }

    function generateContent () {
      // var me = this;
      hotspotDivsArr = $(options.contentClass.val).clone()
      //loop through all divs with class options.contentClass.val
      for (var i = 0; i < hotspotDivsArr.length; i++) {

        //calculate 3d coords based on lat, long and radius
        var _long = $(hotspotDivsArr[i]).data('long')
        var _lat = $(hotspotDivsArr[i]).data('lat')
        
        //transfer data from original div to the hotspot
        var hotspotData = $(hotspotDivsArr[i]).data();
        
        //the add extra info to hotspotData
        hotspotData.pos = translateGeoCoords(_lat, _long, options.globeRadius.val);
        hotspotData.html = $(hotspotDivsArr[i]).html() 
        
        var hotspot = addHotspot(hotspotData);

        //handle mouseEvents
        hotspot.onmouseover = hotspot.onMouseOver
        hotspot.onmouseout = hotspot.onMouseOut

        mee.hotspotsArr.push(hotspot)
      };

    }

    function setupListeners (argument) {
      mee.$elem.on('mousedown', this, onDocumentMouseDown)
      // $elem.on('click', this, onDocumentMouseClick)
      //$elem.on( 'mouseout', this, onDocumentMouseOut );
      // $elem.on( 'mouseenter', this, onDocumentMouseEnter );

      mee.$elem.mousewheel( {this:this}, onDocumentMouseWheel); 

    }

    function onDocumentMouseWheel(event, delta, deltaX, deltaY){
      // var me = event.data.me
      event.preventDefault()
      hideMouseOverDetails()
      //test for firefox / chrome delta
      //var z = (Math.abs(deltaY)>Math.abs(delta))?deltaY:delta
      doZoomCam(delta)
    }

    function onDocumentMouseDown( event ) {
      event.preventDefault();
      // var me = event.data
      mouseDown = true

      mouseY = event.pageY - mee.$elem.offset().top
      mouseX = event.pageX - mee.$elem.offset().left
      
      mee.$elem.on( 'mousemove', this,  onDocumentMouseMove );
      $(document).on( 'mouseup', this, onDocumentMouseUp );
      // mee.$elem.on( 'mouseout', me, onDocumentMouseOut );

      mouseXOnMouseDown = event.clientX - windowDimensionX;
      targetRotationOnMouseDown_x = mee.targetRotation_x;

      mouseYOnMouseDown = event.clientY - windowDimensionY;
      targetRotationOnMouseDown_y =   mee.targetRotation_y;

      //stop autorotation
      options.autoRotate.val = false

      //generate lat longs for output if in debugmode

    }

    function onDocumentMouseMove (event) {
      // var me = event.data

      hideMouseOverDetails()   //hide the menu

      mouseX = event.clientX - windowDimensionX;
      mee.targetRotation_x = targetRotationOnMouseDown_x + ( mouseX - mouseXOnMouseDown ) * 0.01;

      mouseY = event.clientY - windowDimensionY;
        mee.targetRotation_y = targetRotationOnMouseDown_y + ( mouseY - mouseYOnMouseDown ) * 0.01;

    }

    function onDocumentMouseUp (event) {
      // var me = event.data;
      mouseDown = false;
      mee.$elem.off( 'mousemove', onDocumentMouseMove );
      $(document).off( 'mouseup', onDocumentMouseUp );
      render()
    }

    function hideMouseOverDetails () {
      // var me=this;
      mee.hotspotDetails.css({'
        display':'none',
        'transform': 'perspective(400px) rotateX(90deg)',
        '-webkit-transform': 'perspective(400px) rotateX(90deg)'
      })
    }

    function showMouseOverDetails (top,left,content) {
      // var me=this;
      mee.hotspotDetails.css({
        'display':'inline', 
        'top':top, 
        'left':left,
        'transform': 'perspective(400px) rotateX(0deg)',
        '-webkit-transform': 'perspective(400px) rotateX(0deg)'

      })
      mee.hotspotDetails_content.html(content) 

    }


    function setupDebug () {
      // var me = this;
      //me.setupGui()
      //setUpStats()
    }

    function setUpStats () {
      // var me = this;
      stats = new Stats();
      stats.domElement.style.position = 'absolute';
      stats.domElement.style.top = '0px';
      mee.$elem.append( stats.domElement );

    }

    function animate () {
      mee.animationHandler = requestAnimationFrame( animate.bind(mee) );
      // var me = this;
      // console.log(me.targetRotation_y)
      if (  mee.targetRotation_y < -1.4) {  mee.targetRotation_y = -1.4};
      if (  mee.targetRotation_y > 1.4) { mee.targetRotation_y = 1.4};

      //autorotation check
      if (options.autoRotate.val) {
        mee.targetRotation_x = mee.targetRotation_x + options.autoRotateSpeed.val
      };

      mee.globeContainer.rotation.y += ( mee.targetRotation_x - mee.globeContainer.rotation.y ) * options.momentum.val;
      mee.globeContainerParent.rotation.x += (  mee.targetRotation_y - mee.globeContainerParent.rotation.x ) * options.momentum.val;

      TWEEN.update();
      render();

      if(options.debugMode.val===true){
        //stats.update();      
        getRotation()//delete later
      }

    }

    function render () {
      // var me = this;
      mee.renderer.render( mee.scene, camera );
      
      //update hotspots
      for (var i = 0; i < mee.hotspotsArr.length; i++) {
        
        //get hotspot initial, non translated, position
        var hotspotLocalPos = mee.hotspotsArr[i].getPosition()
        
        //convert to vec3
        hotspotLocalPos = new THREE.Vector3( hotspotLocalPos.x, hotspotLocalPos.y, hotspotLocalPos.z )
        
        //transform local position to worldposition
        var coord = mee.globeContainer.localToWorld( hotspotLocalPos )

        //convert worldposition to 2D screencoords
        var screenPos = screenXY( coord );

        //Adjust position for alignment TL, TM, TR, ML, MM, MR, BL, BM, BR
        //get alignmentoption
        var alignOption = mee.hotspotsArr[i].data.hotspotalign;

        //get the divs width and height
        var dim = mee.hotspotsArr[i].data.dim;

        //update values based on alignOption
        switch (alignOption){
          case 'LT':
            break;
          case 'MT':
            screenPos.x = screenPos.x - (dim.width / 2);
            break;
          case 'RT':
            screenPos.x = screenPos.x - (dim.width);
            break;
          case 'LM':
            screenPos.y = screenPos.y - (dim.height / 2);
            break;
          case 'MM':
            screenPos.x = screenPos.x - (dim.width / 2);
            screenPos.y = screenPos.y - (dim.height / 2);
            break;
          case 'RM':
            screenPos.x = screenPos.x - (dim.width);
            screenPos.y = screenPos.y - (dim.height / 2);
            break;
          case 'LB':
            screenPos.y = screenPos.y - (dim.height);
            break;
          case 'MB':
            screenPos.x = screenPos.x - (dim.width / 2);
            screenPos.y = screenPos.y - (dim.height);
            break;
          case 'RB':
            screenPos.x = screenPos.x - (dim.width);
            screenPos.y = screenPos.y - (dim.height);
            break;
          default:
            break;
        }


        //Update the divs position (top, left, z-index)
        mee.hotspotsArr[i].setPosition(screenPos.x, screenPos.y, hotspotLocalPos.z+500)


        //LOD
        mee.hotspotsArr[i].setVisible(hotspotLocalPos.z > 0)
        
      
      };

    }

    function screenXY (vec3) {
      // var me = this;
      var projector = new THREE.Projector();
      var vector = projector.projectVector( vec3.clone(), camera );
      var result = new Object();
      result.x = Math.round( vector.x * (windowDimensionX/2) ) + windowDimensionX/2;
      result.y = Math.round( (0-vector.y) * (windowDimensionY/2) ) + windowDimensionY/2;
      return result;

    }

    function addHotspot (hotspotData ) {
      // console.log(hotspotData)

      var jqHotspot = mee.hotspotTemplate.clone().appendTo(mee.overlay)
      var hotspot = jqHotspot.get(0)

      //set data- attribs to enable links back to original content
      for (var key in hotspotData) {
        $(hotspot).attr('data-'+key,hotspotData[key])
      }

      //add hotspotCssOverride class
      jqHotspot.addClass(options.hotspotCssOverride.val)

      // store data locally
      hotspot.data = hotspotData;

      //add local class overrides
      jqHotspot.addClass(hotspot.data.hotspotclass)

      //handle z-indexing
      hotspot.data.zMod = 0

      //attach icons to hotspots
      if(hotspot.data.hotspoticon==undefined || hotspot.data.hotspoticon==""){
        //update hotspots dataobject to include default icon
        hotspot.data.hotspoticon = options.hotSpotIcon.val
      }

      jqHotspot.html("<img src='"+ options.assetPath.val + hotspot.data.hotspoticon+"' alt='icon'>")

    
      hotspot.selected = false;
      hotspot.hover = false;



      hotspot.onMouseOver = function(event){
        var headtxt = (this.data.headtxt != undefined && this.data.headtxt != "") ? this.data.headtxt : this.data.html    // if data-headtxt is defined, use this in the mouseover else the html
        // showMouseOverDetails($(this).offset().top + this.data.dim.height, $(this).offset().left, headtxt) //doesnt work when container is relative with margin-top...
        showMouseOverDetails($(this).position().top + this.data.dim.height, $(this).position().left, headtxt)

        this.data.zMod = 9999   //make this active mouseover'ed hotspot pop to top by modifying its z-index value
      }

      hotspot.onMouseOut = function(event){
        this.data.zMod = 0    //reset z-index for the hotspot, allowing it to fall back to the correct calculated depth
        hideMouseOverDetails()
      }
      
      hotspot.onmousedown = function(event){
        //handle custom popwidth and height
        var popWidth = (this.data.popwidth!=undefined)?this.data.popwidth:options.popWidth.val
        var popHeight = (this.data.popheight!=undefined)?this.data.popHeight:options.popHeight.val


        if(this.data.clickexternal != undefined && this.data.clickexternal != ""){
          //fire local external function instead of lightbox
          window[this.data.clickexternal](this.data, this)
          return
        }

        if(options.clickExternal.val){
          // console.log("clickexternalVal")
          //fire external function instead of lightbox
          window[options.clickExternal.val](this.data, this)
          return
        }

        if(this.data.url != undefined && this.data.url != ""){

          //open the data-url in either lightbox or as _parent / _blank - defaults to lightbox if data.urltarget==undefined
          if(this.data.urltarget == "_blank" || this.data.urltarget == "_parent"){

            //open url in browserwindow
            window.open( this.data.url, this.data.urltarget);
          }else{

            //open url in lightbox
            $.colorbox({href:this.data.url, iframe:true, width:popWidth, height:popHeight});
          }
        }else{

          //open html in lightbox
          $.colorbox({html:this.data.html, width:popWidth, height:popHeight});
        }
      }


      hotspot.setPosition = function(x,y,z){ //sets the divs top and left css attributes
        this.style.left = x + 'px';
        this.style.top = y + 'px';  
        this.style.zIndex = Math.round(z+this.data.zMod);
      }

      hotspot.setVisible = function( vis ){
        if( ! vis )
          this.style.display = 'none';
        else{
          this.style.display = 'inline';
        }
      }

      hotspot.getPosition = function(){
        return this.data.pos    //return the hotspots initial position, its later translated to correspond to the globes rotation and scale
      }

      hotspot.getDim = function(){    //we need to know the width and height of each hotspot, to account for custom alignment LT, RT ...
        var dim = {}
        var img = new Image();      //img is a temporary placeholder used to measure the hotspot graphics
        img.onload = function(e){
          dim.width = this.width;
          dim.height = this.height;
          document.body.removeChild(img);
        }
        img.src = options.assetPath.val + hotspot.data.hotspoticon;
        img.style.position = "absolute";
        img.style.left = -9999; 
        img.style.visibility = "hidden";    
        document.body.appendChild(img);
        return dim
      }
      //calculate width and height
      hotspot.data.dim = hotspot.getDim()

      return hotspot
    }




    function translateGeoCoords (lat, lng, r) {
      lng = -1 * lng
      var x = r * Math.cos(lat * Math.PI/180) * Math.cos(lng * Math.PI/180);
      var y = r * Math.sin(lat * Math.PI/180);
      var z = r * Math.cos(lat * Math.PI/180) * Math.sin(lng * Math.PI/180);
      
      return { x: x, y: y, z: z }

    }

    /**
     * Public Methods
     */
    function getRotation(){
      //returns the globes rotation
      var lat = mee.globeContainerParent.rotation.x

      //tweak it into place and remove whole revs
      var lng = (mee.globeContainer.rotation.y + Math.PI/2) % (2*Math.PI);

      //reverse direction
      lng *= -1

      //convert to 2*+/-0,5 revs
      if(lng > Math.PI) lng = lng - (2 * Math.PI);

      //create output
      var r = {}
      r._x = lat * 180 / Math.PI;
      r._y = lng * 180 / Math.PI;

      //$('#output').val(r._y)
      return r;

    }

    function getCoords() {
      //returns the mouse coords in lat, long
      // var me = this;
      //get normalized mousecoords -1 -> 1
      var mouse2DX = (mouseX/windowDimensionX)*2-1
      var mouse2DY = -(mouseY/windowDimensionY)*2+1

      //for use with a orthographic camera
      var vecOrigin = new THREE.Vector3( mouse2DX, mouse2DY, options.camZ.val );//

      var ray = projector.pickingRay(vecOrigin, camera)

      var intersects = ray.intersectObject(mee.globeGeo, true);

      if (intersects.length > 0) {

        var p = intersects[0].point
        var local = mee.globeContainer.worldToLocal(p)

        var lat = 90 - (Math.acos(p.y / options.globeRadius.val)) * 180 / Math.PI;
        lat = lat.toFixed(3)
        var lng = ((-270 + (Math.atan2(p.x , p.z)) * 180 / Math.PI) % 360) +180;
        lng = lng.toFixed(3)

        var o = {}
        o.lat = lat
        o.lon = lng
        return o;
      };

    }

    //rebuilds the hotspots
    function refresh () {
      // console.log("refresh")
      //empty iconsarr
      mee.hotspotsArr = []
      //delete icons
      mee.overlay.empty()

      //generate new icons
      $("._hotspot").addClass('hotspot')

      //repopulate iconsarr
      generateContent();
    }

    function rotate(lat, lng) {
      //lat - height
      //lng - width
      //ie - y,x notation
      if (lng != undefined) {
        
        //get current rotation in rads
        var currentAngle_rad = mee.globeContainer.rotation.y
        
        //input angle converted to rads and subtracted whole revs
        var a_rad = (-lng * (Math.PI / 180)) % (2*Math.PI)
        
        // make it hit 0 when user inputs 0 - because the camera is looking at a 90 angle
        var correction_rad = (Math.PI/2)*-1

        //subtract whole revs from globe
        mee.globeContainer.rotation.y = currentAngle_rad % (2*Math.PI)

        //tween rotation to new angle
        mee.targetRotation_x = a_rad + correction_rad 
      };
      
      if (lat != undefined) {
        mee.targetRotation_y = ((lat) * (Math.PI / 180)) % (Math.PI)
        // console.log(mee.targetRotation_y)
      };
    }
 
    /**
     * Get/set a plugin option.
     * Get usage: $('#el').demoplugin('option', 'key');
     * Set usage: $('#el').demoplugin('option', 'key', value);
     */
    function option (key, val) {
      if (val) {
        options[key] = val;
      } else {
        return options[key];
      }
      // console.log(options)
    }

    //returns optionsobject
    function getOptions(){
      return options;
    }
 
    //reinitializes the globe, used when generator adds/changes options/hotspots
    function reInit(currRotation){
      // console.log("reinitsGlobe")
      init()
      rotate(currRotation._x, currRotation._y)
    }
 
    /**
     * Destroy plugin.
     * Usage: $('#el').demoplugin('destroy');
     */
    function destroy() {
      // Iterate over each matching element.
      $el.each(function() {
        var el = this;
        var $el = $(this);
 
        // Add code to restore the element to its original state...
 
        hook('onDestroy');
        // Remove Plugin instance from the element.
        $el.removeData('plugin_' + pluginName);
      });
    }
 
    /**
     * Callback hooks.
     * Usage: In the defaults object specify a callback function:
     * hookName: function() {}
     * Then somewhere in the plugin trigger the callback:
     * hook('hookName');
     */
    function hook(hookName) {
      if (options[hookName] !== undefined) {
        // Call the user defined function.
        // Scope is set to the jQuery element we are operating on.
        options[hookName].call(el);
      }
    }
 
    // Initialize the plugin instance.
    init();
 
    // Expose methods of Plugin we wish to be public.
    return {
      option: option,
      // destroy: destroy,
      rotate: rotate,
      refresh: refresh,
      getOptions: getOptions,
      reInit: reInit,
      getCoords:getCoords,
      getRotation:getRotation
    };
  }
 
  /**
   * Plugin definition.
   */
  $.fn[pluginName] = function(options) {
    // If the first parameter is a string, treat this as a call to
    // a public method.
    if (typeof arguments[0] === 'string') {
      var methodName = arguments[0];
      var args = Array.prototype.slice.call(arguments, 1);
      var returnVal;
      this.each(function() {
        // Check that the element has a plugin instance, and that
        // the requested public method exists.
        if ($.data(this, 'plugin_' + pluginName) && typeof $.data(this, 'plugin_' + pluginName)[methodName] === 'function') {
          // Call the method of the Plugin instance, and Pass it
          // the supplied arguments.
          returnVal = $.data(this, 'plugin_' + pluginName)[methodName].apply(this, args);
        } else {
          throw new Error('Method ' +  methodName + ' does not exist on jQuery.' + pluginName);
        }
      });
      if (returnVal !== undefined){
        // If the method returned a value, return the value.
        return returnVal;
      } else {
        // Otherwise, returning 'this' preserves chainability.
        return this;
      }

    // If the first parameter is an object (options), or was omitted,
    // instantiate a new instance of the plugin.
    } else if (typeof options === "object" || !options) {
      return this.each(function() {
        // Only allow the plugin to be instantiated once.
        if (!$.data(this, 'plugin_' + pluginName)) {
          // Pass options to Plugin constructor, and store Plugin
          // instance in the elements jQuery data object.
          _me = $.data(this, 'plugin_' + pluginName, new Plugin(this, options));

          // console.log($.data(this, 'plugin_' + pluginName))
        }
      });
    }
  };
 
  // Default plugin options.
  // Options can be overwritten when initializing plugin, by
  // passing an object literal, or after initialization:
  // $('#el').demoplugin('option', 'key', value);
  $.fn[pluginName].options = {
    globeRadius:{val: 200, desc:"defines the size of the globe"},
    globeShine:{val: 30, desc:"defines the shininess of the globes material"},
    globeTexture:{val: "textures/earthmap10k_comp.jpg"/*"textures/terra_equi.jpg"*/, desc:"defines wich texture to use for the globe"},
    globeBump:{val: "textures/earthbump1k.jpg"/*"textures/terra_equi.jpg"*/, desc:"defines wich texture to use for the globe"},
    globeMinScale:{val: 0.3, desc:"sets minimum zoomlevel"},
    globeMaxScale:{val: 7, desc:"sets maximum zoomlevel"},
    globeSegments:{val: 50, desc:"defines the globes coarsness - high value (50) gives smooth and round globe, lower values might increase performance on slow systems"},
    momentum:{val: 0.07, desc:"defines the globes rotation-momentum, low values produce more momentum (the globe appears heavier)"},
    ambientIntensity:{val: 4.6, desc:"defines intensity for the ambient light"},
    ambientColor:{val: "#555584", desc:"defines color for the ambient light"},
    ambientPosX:{val: 5000, desc:"defines x position for the ambient light"},
    ambientPosY:{val: -824, desc:"defines y position for the ambient light"},
    ambientPosZ:{val: 495, desc:"defines z position for the ambient light"},
    headLampIntensity:{val: 1.2, desc:"defines intensity for the main light"},
    headLampColor:{val: "#ffffff", desc:"defines color for the main light"},
    headLampPosX:{val: -1000, desc:"defines x position for the main light"},
    headLampPosY:{val: 1000, desc:"defines y position for the main light"},
    headLampPosZ:{val: 1000, desc:"defines z position for the main light"},
    hotSpotIcon:{val: "textures/hotspotIconsOrange/nano_LT.png",  desc:"default texture for the hotspots - hotspots are alignet left-top by default"},
    backPlateTexture:{val: "textures/backPlate_glow.png", desc:"texture for the globes halo"},
    backPlateMargin:{val: 50, desc:"defines how far the halo extends from the globe"},
    debugMode:{val: "false", desc:"used for testing"},
    popWidth:{val: 850,  desc:"default maxwidth for colorbox popup"},
    popHeight:{val: 620,  desc:"default maxheight for colorbox popup"},
    camX:{val: 0,  desc:"default camera x position"},
    camY:{val: 0,  desc:"default camera y position"},
    camZ:{val: 1500, desc:"default camera z position"},
    contentClass:{val: ".hotspot", desc:"wich class to use for hotspotgeneration"},
    hotspotCssOverride:{val: "hotspot_override", desc:"Use this to override graphic properties on hotspots"},
    cameraTargetX:{val:0 , desc:"cameras target x position"},
    cameraTargetY:{val:0 , desc:"cameras target y position"},
    cameraTargetZ:{val:0 , desc:"cameras target z position"},
    autoRotateSpeed:{val: .02, desc:"sets the speed on autorotate"},
    autoRotate:{val: true, desc:"makes the globe autorotate on startup"},
    clickExternal:{val: false, desc:"name of custom function to call on hotspotclick - overrides the default lightbox popup"},
    assetPath:{val: '', desc:"Use this to prepend all assets with a path"},

  };

 
})(jQuery);