
/*
	Global functions
*/
function htmlspecialchars(str){

	var map = {
		'&': '&amp;',
		'<': '&lt;',
		'>': '&gt;',
		'"': '&quot;',
		"'": '&#039;'
	}

	return str.replace(/[&<>"']/g, function(m){return map[m];});
}

function htmlspecialchars_decode(str){
	
	var map = {
		'&amp;': '&',
		'&lt;': '<',
		'&gt;': '>',
		'&quot;': '"',
		'&#039;': "'"
	}
	
	return str.replace(/&amp;|&lt;|&gt;|&quot;|&#039;/g, function(m){return map[m];});
}

function is_click_within(elem, classname, is_id = false){
	
	while(true){
		
		if(elem === null){
			
			return false;
		}
		
		if(
			(
				is_id === false &&
				elem.className == classname
			) ||
			(
				is_id === true &&
				elem.id == classname
			)
		){
			
			return elem;
		}
		
		elem = elem.parentElement;
	}
}



/*
	Prevent GET parameter pollution
*/
var form = document.getElementsByTagName("form");

if(
	form.length !== 0 &&
	window.location.pathname != "/" &&
	window.location.pathname != "/settings.php" &&
	window.location.pathname != "/settings"
){
	form = form[0];
	
	var scraper_dropdown = document.getElementsByName("scraper")[0];
	
	scraper_dropdown.addEventListener("change", function(choice){
		
		submit(form);
	});
	
	form.addEventListener("submit", function(e){
		
		e.preventDefault();
		submit(e.srcElement);
	});
}

function submit(e){
	
	var GET = "";
	var first = true;
	
	if((s = document.getElementsByName("s")).length !== 0){
		
		GET += "?s=" + encodeURIComponent(s[0].value).replaceAll("%20", "+");
		first = false;
	}
	
	Array.from(
		e.getElementsByTagName("select")
	).concat(
		Array.from(
			e.getElementsByTagName("input")
		)
	).forEach(function(el){
		
		var firstelem = el.getElementsByTagName("option");
		
		if(
			(
				(
					firstelem.length === 0 ||
					firstelem[0].value != el.value
				) &&
				el.name != "" &&
				el.value != "" &&
				el.name != "s"
			) ||
			el.name == "scraper" ||
			el.name == "nsfw"
		){
			
			if(first){
				
				GET += "?";
				first = false;
			}else{
				
				GET += "&";
			}
			
			GET += encodeURIComponent(el.name).replaceAll("%20", "+") + "=" + encodeURIComponent(el.value).replaceAll("%20", "+");
		}
	});
	
	window.location.href = GET;
}



/*
	Hide show more button when it's not needed on answers
*/
var answer_div = document.getElementsByClassName("answer");

if(answer_div.length !== 0){
	answer_div = Array.from(answer_div);
	var spoiler_button_div = Array.from(document.getElementsByClassName("spoiler-button"));

	// execute on pageload
	hide_show_more();

	window.addEventListener("resize", hide_show_more);

	function hide_show_more(){
		
		var height = window.innerWidth >= 1000 ? 600 : 200;
		
		for(i=0; i<answer_div.length; i++){
			
			if(answer_div[i].scrollHeight < height){
				
				spoiler_button_div[i].style.display = "none";
				
				document.getElementById(spoiler_button_div[i].htmlFor).checked = true;
			}else{
				
				spoiler_button_div[i].style.display = "block";
			}
		}
	}
}

switch(document.location.pathname){
	
	case "/web":
	case "/web.php":
		var image_class = "image";
		break;
	
	case "/images":
	case "/images.php":
		var image_class = "thumb";
		break;
	
	default:
		var image_class = null;
}

if(image_class !== null){
	
	/*
		Add popup to document
	*/
	var popup_bg = document.createElement("div");
	popup_bg.id = "popup-bg";
	document.body.appendChild(popup_bg);
	
	// enable/disable pointer events
	if(!document.cookie.includes("bg_noclick=yes")){
		
		popup_bg.style.pointerEvents = "none";
	}
	
	var popup_status = document.createElement("div");
	popup_status.id = "popup-status";
	document.body.appendChild(popup_status);
	
	var popup_body = document.createElement("div");
	popup_body.id = "popup";
	document.body.appendChild(popup_body);
	
	// import popup
	var popup_body = document.getElementById("popup");
	var popup_status = document.getElementById("popup-status");
	var popup_image = null; // is set later on popup click
	
	// image metadata
	var collection = []; // will contain width, height, image URL
	var collection_index = 0;
	
	// event handling helper variables
	var is_popup_shown = false;
	var mouse_down = false;
	var mouse_move = false;
	var move_x = 0;
	var move_y = 0;
	var target_is_popup = false;
	var mirror_x = false;
	var mirror_y = false;
	var rotation = 0;
	
	/*
		Image dragging (mousedown)
	*/
	document.addEventListener("mousedown", function(div){
		
		if(div.buttons !== 1){
			
			return;
		}
		
		mouse_down = true;
		mouse_move = false;
		
		if(is_click_within(div.target, "popup", true) === false){
			
			target_is_popup = false;
		}else{

			target_is_popup = true;
			
			var pos = popup_body.getBoundingClientRect();
			move_x = div.x - pos.x;
			move_y = div.y - pos.y;
		}
	});
	
	/*
		Image dragging (mousemove)
	*/
	document.addEventListener("mousemove", function(pos){
		
		if(
			target_is_popup &&
			mouse_down
		){
			
			mouse_move = true;
			movepopup(popup_body, pos.clientX - move_x, pos.clientY - move_y);
		}
	});
	
	/*
		Image dragging (mouseup)
	*/
	document.addEventListener("mouseup", function(){
		
		mouse_down = false;
	});
	
	/*
		Image popup open
	*/
	document.addEventListener("click", function(click){
		
		// should our click trigger image open?
		if(
			elem = is_click_within(click.target, image_class) ||
			click.target.classList.contains("openimg")
		){
			
			event.preventDefault();
			is_popup_shown = true;
			
			// reset position params
			mirror_x = false;
			mirror_y = false;
			rotation = 0;
			scale = 60;
			collection_index = 0;
			
			// get popup data
			if(elem === true){
				// we clicked a simple image preview
				elem = click.target;
				var image_url = elem.getAttribute("src");
				
				if(image_url.startsWith("/proxy")){
					
					var match = image_url.match(/i=([^&]+)/);
					
					if(match !== null){
						
						image_url = decodeURIComponent(match[1]);
					}
				}else{
					
					image_url = htmlspecialchars_decode(image_url);
				}
				
				collection = [
					{
						"url": image_url,
						"width": Math.round(click.target.naturalWidth),
						"height": Math.round(click.target.naturalHeight)
					}
				];
				
				var title = "No description provided";
				
				if(click.target.title != ""){
					
					title = click.target.title;
				}else{
					
					if(click.target.alt != ""){
						
						title = click.target.alt;
					}
				}
			}else{
				
				if(image_class == "thumb"){
					// we're inside image.php
					
					elem =
						elem
						.parentElement
						.parentElement;
					
					var image_url = elem.getElementsByTagName("a")[1].href;
				}else{
					
					// we're inside web.php
					var image_url = elem.href;
				}
				
				collection =
					JSON.parse(
						elem.getAttribute("data-json")
					);
				
				var title = elem.title;
			}
			
			// prepare HTML
			var html =
				'<div id="popup-num">(' + collection.length + ')</div>' + 
				'<div id="popup-dropdown">' +
					'<select name="viewer-res" onchange="changeimage(event)">';
			
			for(i=0; i<collection.length; i++){
				
				if(collection[i].url.startsWith("data:")){
					
					var domain = "&lt;Base64 Data&gt;";
				}else{
					
					var domain = new URL(collection[i].url).hostname;
				}
				
				html += '<option value="' + i + '">' + '(' + collection[i].width + 'x' + collection[i].height + ') ' + domain + '</option>';
			}
			
			popup_status.innerHTML =
				html + '</select></div>' +
				'<a href="' + htmlspecialchars(image_url) + '" rel="noreferrer nofollow "id="popup-title">' + htmlspecialchars(title) + '</a>';
			
			popup_body.innerHTML =
				'<img src="' + getproxylink(collection[0].url) + '" draggable="false" id="popup-image">';
			
			// make changes to DOM
			popup_body.style.display = "block";
			popup_bg.style.display = "block";
			popup_status.style.display = "table";
			
			// store for rotation functions & changeimage()
			popup_image = document.getElementById("popup-image");
			
			scalepopup(collection[collection_index], scale);
			centerpopup();
		}else{
			
			// click inside the image viewer
			// resize image
			if(is_click_within(click.target, "popup", true)){
				
				if(mouse_move === false){
					scale = 80;
					scalepopup(collection[collection_index], scale);
					centerpopup();
				}
			}else{
				
				if(is_click_within(click.target, "popup-status", true) === false){
					
					// click outside the popup while its open
					// close it
					if(is_popup_shown){
						
						hidepopup();
					}
				}
			}
		}
	});
	
	/*
		Scale image viewer
	*/
	popup_body.addEventListener("wheel", function(scroll){
		
		event.preventDefault();
		
		if(
			scroll.altKey ||
			scroll.ctrlKey ||
			scroll.shiftKey
		){
			
			var increment = 7;
		}else{
			
			var increment = 14;
		}
		
		if(scroll.wheelDelta > 0){
			
			// scrolling up
			scale = scale + increment;
		}else{
			
			// scrolling down
			if(scale - increment > 7){
				scale = scale - increment;
			}
		}
		
		// calculate relative size before scroll
		var pos = popup_body.getBoundingClientRect();
		var x = (scroll.x - pos.x) / pos.width;
		var y = (scroll.y - pos.y) / pos.height;
		
		scalepopup(collection[collection_index], scale);
		
		// move popup to % we found
		pos = popup_body.getBoundingClientRect();
		
		movepopup(
			popup_body,
			scroll.clientX - (x * pos.width),
			scroll.clientY - (y * pos.height)
		);
	});
	
	/*
		Keyboard controls
	*/
	
	document.addEventListener("keydown", function(key){
		
		// close popup
		if(
			is_popup_shown &&
			key.keyCode === 27
		){
			
			hidepopup();
			return;
		}
		
		if(is_popup_shown === false){
			
			return;
		}
		
		if(
			key.altKey ||
			key.ctrlKey ||
			key.shiftKey
		){
			
			// mirror image
			switch(key.keyCode){
				
				case 37:
					// left
					key.preventDefault();
					mirror_x = true;
					break;
				
				case 38:
					// up
					key.preventDefault();
					mirror_y = false;
					break;
				
				case 39:
					// right
					key.preventDefault();
					mirror_x = false;
					break;
				
				case 40:
					// down
					key.preventDefault();
					mirror_y = true;
					break;
			}
		}else{
			
			// rotate image
			switch(key.keyCode){
				
				case 37:
					// left
					key.preventDefault();
					rotation = -90;
					break;
				
				case 38:
					// up
					key.preventDefault();
					rotation = 0;
					break;
				
				case 39:
					// right
					key.preventDefault();
					rotation = 90;
					break;
				
				case 40:
					// down
					key.preventDefault();
					rotation = -180;
					break;
			}
		}
		
		popup_image.style.transform =
			"scale(" +
				(mirror_x ? "-1" : "1") +
				", " +
				(mirror_y ? "-1" : "1") +
			") " +
			"rotate(" +
				rotation + "deg" +
			")";
	});
}

function getproxylink(url){
	
	if(url.startsWith("data:")){
		
		return htmlspecialchars(url);
	}else{
		
		return '/proxy?i=' + encodeURIComponent(url);
	}
}

function hidepopup(){
	
	is_popup_shown = false;
	popup_status.style.display = "none";
	popup_body.style.display = "none";
	popup_bg.style.display = "none";
}

function scalepopup(size, scale){
	
	var ratio =
		Math.min(
			(window.innerWidth * (scale / 100)) / collection[collection_index].width, (window.innerHeight * (scale / 100)) / collection[collection_index].height
		);
	
	popup_body.style.width = size.width * ratio + "px";
	popup_body.style.height = size.height * ratio + "px";
}

function centerpopup(){
	
	var size = popup_body.getBoundingClientRect();
	var size = {
		"width": parseInt(size.width),
		"height": parseInt(size.height)
	};
	
	movepopup(
		popup_body,
		(window.innerWidth / 2) - (size.width / 2),
		(window.innerHeight / 2) - (size.height / 2)
	);
}

function movepopup(popup_body, x, y){
	
	popup_body.style.left = x + "px";
	popup_body.style.top = y + "px";
}

function changeimage(event){
	
	// reset rotation params
	mirror_x = false;
	mirror_y = false;
	rotation = 0;
	
	scale = 60;
	
	collection_index = parseInt(event.target.value);
	
	// we set innerHTML otherwise old image lingers a little
	popup_body.innerHTML =
		'<img src="' + getproxylink(collection[collection_index].url) + '" draggable="false" id="popup-image">';
	
	// store for rotation functions & changeimage()
	popup_image = document.getElementById("popup-image");
	
	scalepopup(collection[collection_index], scale);
	centerpopup();
}

/*
	Shortcuts
*/
var searchbox_wrapper = document.getElementsByClassName("searchbox");

if(searchbox_wrapper.length !== 0){
	searchbox_wrapper = searchbox_wrapper[0];
	var searchbox = searchbox_wrapper.getElementsByTagName("input")[1];

	document.addEventListener("keydown", function(key){
		
		switch(key.keyCode){
			
			case 191:
				// 191 = /
				if(document.activeElement.tagName == "INPUT"){
					
					// already focused, ignore
					break;
				}
				
				if(
					typeof is_popup_shown != "undefined" &&
					is_popup_shown
				){
					
					hidepopup();
				}
				
				window.scrollTo(0, 0);
				searchbox.focus();
				key.preventDefault();
				break;
		}
	});
}
