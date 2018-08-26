/**
 *
 * HTML5 Image uploader with Jcrop
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2012, Script Tutorials
 * http://www.script-tutorials.com/
 */

// convert bytes into friendly format
function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB'];
    if (bytes == 0) return 'n/a';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
};

// check for selected crop region
function checkForm() {
    if (parseInt($('#w').val())) return true;
    $('.error').html('Please select a crop region and then press Upload').show();
    return false;
};

// update info by cropping (onChange and onSelect events handler)
function updateInfo(e) {
    $('#x1').val(Math.floor(e.x));
    $('#y1').val(Math.floor(e.y));
    $('#x2').val(Math.floor(e.x2));
    $('#y2').val(Math.floor(e.y2));
    $('#w').val(Math.floor(e.w));
    $('#h').val(Math.floor(e.h));
};

// clear info by cropping (onRelease event handler)
function clearInfo() {
    $('.info #w').val('');
    $('.info #h').val('');
};

var jcrop_api, boundx, boundy;

function fileSelectHandler() {

    // get selected file
    var oFile = $('#image_file')[0].files[0];

    // hide all errors
    $('.error').hide();

    // check for image type (jpg and png are allowed)
    var rFilter = /^(image\/jpeg|image\/png|image\/gif)$/i;
    if (! rFilter.test(oFile.type)) {
        $('.error').html('Please select a valid image file (jpg and png are allowed)').show();
        return;
    }

    // check for file size
    if (oFile.size > 250 * 1024) {
        $('.error').html('You have selected too big file, please select a one smaller image file').show();
        return;
    }

    // preview element
    var oImage = document.getElementById('preview');
	 

    // prepare HTML5 FileReader
    var oReader = new FileReader();
        oReader.onload = function(e) {

        // e.target.result contains the DataURL which we can use as a source of the image
        oImage.src = e.target.result;
        oImage.onload = function () { // onload event handler

            // display step 2
			//$('#div_upload_step_1').hide();
            //$('#div_upload_step_2').fadeIn(500);
			//$('#btn_senb_image').removeClass('disabled');
			viewStep(2);

            // display some basic image info
            var sResultFileSize = bytesToSize(oFile.size);
            $('#filesize').val(sResultFileSize);
            $('#filetype').val(oFile.type);
            $('#filedim').val(oImage.naturalWidth + ' x ' + oImage.naturalHeight);
			$('#filedimw').val(oImage.naturalWidth);
			$('#filedimy').val(oImage.naturalHeight);

            // Create variables (in this scope) to hold the Jcrop API and image size

            // destroy Jcrop if it is existed
			//$('#filesize').val() != ''
            if ( typeof jcrop_api != 'undefined' ){//()
                destroyJcrop(jcrop_api);
			}//if
			
			//alert(jcrop_api);

            // initialize Jcrop
			initJcrop(oImage.naturalWidth,oImage.naturalHeight);
           
        };
    };

    // read selected file as DataURL
    oReader.readAsDataURL(oFile);
}

function destroyJcrop(objeto){
	objeto.destroy();
}

function initJcrop(w,h){
	
	var min_w = 200;
	var min_h = 200;
	var ini_x = 0;
	var ini_y = 0;
	
	var max_w = 0;
	var max_h = 0;
	
	
	
	var msg_span = "Selecione a area";
	
	if(w < 200){
		min_w = w;
		max_h = min_h;
		msg_span = "Sua imagem possui dimensões menores a 200px (largo) e 200px (alto). Ela pode não ficar tão boa quanto uma imagem com pelo menos essas dimensões. Deseja continuar?";
	}//else 
	if(h < 200){
		max_w = min_w;
		min_h = h;
		msg_span = "Sua imagem possui dimensões menores a 200px (largo) e 200px (alto). Ela pode não ficar tão boa quanto uma imagem com pelo menos essas dimensões. Deseja continuar?";
	}//else{

	//}//if
	
	var sel_w = min_w;
	var sel_h = min_h;
	
	if(w > min_w && h > min_h){
		
		if(w > h){
			sel_h = h;// - 2;
			sel_w = h;// - 2;//w * sel_h / h;
		}else if(h > w){
			sel_w = w;// - 2;
			sel_h = w;// - 2;//h * sel_w / w;
		}
		
	}
	

	ini_x = ((w - sel_w)>0)?Math.floor((w - sel_w) / 2):0;
	ini_y = ((h - sel_h)>0)?Math.floor((h - sel_h) / 2):0;
	

	//$('#spn_img_msg').text(ini_x+', '+ini_y+', '+ini_x+'+'+sel_w+', '+ini_y+'+'+sel_h+ '('+w+','+h+')');
	
	 $('#preview').Jcrop({
								
			boxWidth: 500,
			boxHeight: 400,
			
			boohWidth: w,
			boohHeight: h,
			
			bgColor:     'black',
			bgOpacity:   .4,
			setSelect:   [ ini_x, ini_y, ini_x + sel_w, ini_y + sel_h],
			
			minSize: [min_w, min_h], // min crop size
			maxSize: [max_w, max_h], // max crop size
			aspectRatio : (min_w == min_h)?1:0, // keep aspect ratio 1:1
			bgFade: true, // use fade effect
			//bgOpacity: .3, // fade opacity
			onChange: updateInfo,
			onSelect: updateInfo,
			onRelease: clearInfo
		}, function(){

			// use the Jcrop API to get the real image size
			//var bounds = this.getBounds();
			//boundx = bounds[0];
			//boundy = bounds[1];
			
			//this.setOptions({boxWidth:boundx,boxHeight:boundy});
			//this.boxHeight = boundy;
			
			//alert(oImage.naturalWidth + ':' + oImage.naturalHeight);
			//this.setOptions({boohWidth:oImage.naturalWidth,boohHeight:oImage.naturalHeight});
			//this.boohWidth = oImage.naturalWidth;

			// Store the Jcrop API in the jcrop_api variable
			jcrop_api = this;
		});
}
function setImage(quem,caminho,arquivo){
    document.getElementById(quem).src = caminho+'/'+arquivo;
    document.getElementById('hdd_'+quem).value = arquivo;
}

function FecharUploadImagem(){
	viewStep(1);
	$('#divUploadImagem').hide();
	document.getElementById('upload_form').reset();
	//showFundoModal(false);
}

function AbrirUploadImagem(opcoes){
	document.getElementById('upload_form').reset();
	if(opcoes != 'undefined' && opcoes != null && opcoes!= '')document.getElementById('hdd_img_upload_opt').value = opcoes;
	viewStep(1);
	$('#divUploadImagem').show();
	//showFundoModal(true);
}

function sendImage(){
	if($('#btn_senb_image').hasClass('disabled'))return false;
	document.getElementById('preview').src = '';
	document.getElementById('upload_form').submit();
}//if

function viewStep(qual){
	
	$('#btn_step1_image').hide();
	
	$('#div_upload_step_1').hide();
	$('#div_upload_step_2').hide();
	
	if(qual > 0){
		$('#div_upload_step_'+qual).show();
		if(qual==1){
			document.getElementById('upload_form').reset();
			$('#btn_senb_image').addClass('disabled');
		}else if(qual==2){
			$('#btn_step1_image').show();
			$('#btn_senb_image').removeClass('disabled');
		}
	}//if
}//if
