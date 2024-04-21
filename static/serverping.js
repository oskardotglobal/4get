
function htmlspecialchars(str){
	
	if(str === null){
		
		return "<i>&lt;Empty&gt;</i>";
	}
	
	var map = {
		'&': '&amp;',
		'<': '&lt;',
		'>': '&gt;',
		'"': '&quot;',
		"'": '&#039;'
	}

	return str.replace(/[&<>"']/g, function(m){return map[m];});
}

// initialize garbage
var list = [];
var pinged_list = [];
var reqs = 0;
var errors = 0;
var sort = 6; // highest version first

// check for instance redirect stuff
var redir = [];
var target = "/web?";
new URL(window.location.href)
	.searchParams
	.forEach(
		function(value, key){
			
			if(key == "target"){
				
				target = "/" + encodeURIComponent(value) + "?";
				return;
			}
			
			if(key == "npt"){ return; }
			redir.push(encodeURIComponent(key) + "=" + encodeURIComponent(value))
		}
	);

if(redir.length !== 0){
	
	redir = target + redir.join("&");
}else{
	
	redir = "";
}

var quote = document.createElement("div");
quote.className = "quote";
quote.innerHTML = 'Pinged <b>0</b> servers (<b>0</b> failed requests)';
var [div_servercount, div_failedreqs] =
	quote.getElementsByTagName("b");

var noscript = document.getElementsByTagName("noscript")[0];
document.body.insertBefore(quote, noscript.nextSibling);

// create table
var table = document.createElement("table");
table.innerHTML =
	'<thead>' +
	'<tr>' +
		'<th class="extend">Server</th>' +
		'<th>Address</th>' +
		'<th>Bot protection</th>' +
		'<th title="Amount of legit requests processed since the last APCU cache clear (usually happens at midnight)">Real reqs (?)</th>' +
		'<th title="Amount of filtered requests processed since the last APCU cache clear (usually happens at midnight)">Bot reqs (?)</th>' +
		'<th>API</th>' +
		'<th><div class="arrow up"></div>Version</th>' +
	'</tr>' +
	'</thead>' +
	'<tbody></tbody>';

document.body.insertBefore(table, quote.nextSibling);

// handle sorting clicks
var tbody = table.getElementsByTagName("tbody")[0];
var th = table.getElementsByTagName("th");

for(var i=0; i<th.length; i++){
	
	th[i].addEventListener("click", function(event){
		
		if(event.target.className.includes("arrow")){
			
			var div = event.target.parentElement;
		}else{
			
			var div = event.target;
		}
		
		var arrow = div.getElementsByClassName("arrow");
		var orientation = 0; // up
		
		if(arrow.length === 0){
			
			// delete arrow and add new one
			arrow = document.getElementsByClassName("arrow");
			arrow[0].remove();
			
			arrow = document.createElement("div");
			arrow.className = "arrow up";
			div.insertBefore(arrow, event.target.firstChild);
		}else{
			
			// switch arrow position
			if(arrow[0].className == "arrow down"){
				
				arrow[0].className = "arrow up";
			}else{
				
				arrow[0].className = "arrow down";
				orientation = 1;
			}
		}
		
		switch(div.textContent.toLowerCase()){
			
			case "server": sort = 0 + orientation; break;
			case "address": sort = 2 + orientation; break;
			case "bot protection": sort = 4 + orientation; break;
			case "real reqs (?)": sort = 6 + orientation; break;
			case "bot reqs (?)": sort = 8 + orientation; break;
			case "api": sort = 10 + orientation; break;
			case "version": sort = 12 + orientation; break;
		}
		
		render_list();
	});
}

function validate_url(url, allow_http = false){
	
	try{
		
		url = new URL(url);
		if(
			url.protocol == "https:" ||
			(
				(
					allow_http === true ||
					window.location.protocol == "http:"
				) &&
				url.protocol == "http:"
			)
		){
			
			return true;
		}
	}catch(error){} // do nothing
	
	return false;
}

function number_format(int){
	
	return new Intl.NumberFormat().format(int);
}

// parse initial server list
fetch_server(window.location.origin);

async function fetch_server(server){
	
	if(!validate_url(server)){
		console.warn("Invalid server URL: " + server);
		return;
	}
	
	// make sure baseURL is origin
	server = new URL(server).origin;
	// prevent multiple fetches
	for(var i=0; i<list.length; i++){
		
		if(list[i] == server){
			
			// serber was already fetched
			return;
		}
	}
	
	// prevent future fetches
	list.push(server);
	
	var data = null;
	
	try{
		
		var payload = await fetch(server + "/ami4get");
		
		if(payload.status !== 200){
			
			// endpoint is not available
			errors++;
			div_failedreqs.textContent = number_format(errors);
			console.warn(server + ": Invalid HTTP code " + payload.status);
			return;
		}
		
		data = await payload.json();
		
	}catch(error){
		
		errors++;
		div_failedreqs.textContent = number_format(errors);
		console.warn(server + ": Could not fetch or decode JSON");
		return;
	}
	
	// sanitize data
	if(
		typeof data.status != "string" ||
		data.status != "ok" ||
		typeof data.server != "object" ||
		!(
			typeof data.server.name == "string" ||
			(
				typeof data.server.name == "object" &&
				data.server.name === null
			)
		) ||
		typeof data.service != "string" ||
		data.service != "4get" ||
		(
			typeof data.server.description != "string" &&
			data.server.description !== null
		) ||
		typeof data.server.bot_protection != "number" ||
		typeof data.server.real_requests != "number" ||
		typeof data.server.bot_requests != "number" ||
		typeof data.server.api_enabled != "boolean" ||
		typeof data.server.alt_addresses != "object" ||
		typeof data.server.version != "number" ||
		typeof data.instances != "object"
	){
		
		errors++;
		div_failedreqs.textContent = number_format(errors);
		console.warn(server + ": Malformed JSON");
		return;
	}
	
	data.server.ip = server;
	
	reqs++;
	div_servercount.textContent = number_format(reqs);
	
	var total = pinged_list.push(data) - 1;
	pinged_list[total].index = total;
	
	render_list();
	
	// get more serbers
	for(var i=0; i<data.instances.length; i++){
		
		fetch_server(data.instances[i]);
	}
}

function sorta(object, element, order){
	
	return object.slice().sort(
		function(a, b){
			
			if(order){
				
				return a.server[element] - b.server[element];
			}
			
			return b.server[element] - a.server[element];
		}
	);
}

function textsort(object, element, order){
	
	var sort = object.slice().sort(
		function(a, b){
			
			return a.server[element].localeCompare(b.server[element]);
		}
	);
	
	if(!order){
		return sort.reverse();
	}
	
	return sort;
}

function render_list(){
	
	var sorted_list = [];
	
	// sort
	var filter = Boolean(sort % 2);
	
	switch(sort){
		
		case 0:
		case 1:
			sorted_list = textsort(pinged_list, "name", filter === true ? false : true);
			break;
		
		case 2:
		case 3:
			sorted_list = textsort(pinged_list, "ip", filter === true ? false : true);
			break;
		
		case 4:
		case 5:
			sorted_list = sorta(pinged_list, "bot_protection", filter === true ? false : true);
			break;
		
		case 6:
		case 7:
			sorted_list = sorta(pinged_list, "real_requests", filter);
			break;
		
		case 8:
		case 9:
			sorted_list = sorta(pinged_list, "bot_requests", filter);
			break;
		
		case 10:
		case 11:
			sorted_list = sorta(pinged_list, "api_enabled", filter);
			break;
		
		case 12:
		case 13:
			sorted_list = sorta(pinged_list, "version", filter);
			break;
	}
	
	// render tabloid
	var html = "";
	
	for(var k=0; k<sorted_list.length; k++){
		
		html += '<tr onclick="show_server(' + sorted_list[k].index + ');">';
		
		for(var i=0; i<7; i++){
			
			html += '<td';
			
			switch(i){
				
				// server name
				case 0: html += ' class="extend">' + htmlspecialchars(sorted_list[k].server.name); break;
				case 1: html += '>' + htmlspecialchars(new URL(sorted_list[k].server.ip).host); break;
				case 2: // bot protection
					switch(sorted_list[k].server.bot_protection){
						
						case 0:
							html += '><span style="color:var(--green);">Disabled</span>';
							break;
						
						case 1:
							html += '><span style="color:var(--yellow);">Image captcha</span>';
							break;
						
						case 2:
							html += '><span style="color:var(--red);">Invite only</span>';
							break;
						
						default:
							html += '>Unknown';
					}
					break;
				
				case 3: // real reqs
					html += '>' + number_format(sorted_list[k].server.real_requests);
					break;
				
				case 4: // bot reqs
					html += '>' + number_format(sorted_list[k].server.bot_requests);
					break;
				
				case 5: // api enabled
					
					if(sorted_list[k].server.api_enabled){
						
						html += '><span style="color:var(--green);">Yes</span>';
					}else{
						
						html += '><span style="color:var(--red);">No</span>';
					}
					break;
				
				// version
				case 6: html += ">v" + sorted_list[k].server.version; break;
			}
			
			html += '</td>';
		}
		
		html += '</tr>';
	}
	
	console.log(html);
	
	tbody.innerHTML = html;
}

var popup_bg = document.getElementById("popup-bg");
var popup_wrapper = document.getElementsByClassName("popup-wrapper")[0];
var popup = popup_wrapper.getElementsByClassName("popup")[0];
var popup_shown = false;

popup_bg.addEventListener("click", function(){
	
	popup_wrapper.style.display = "none";
	popup_bg.style.display = "none";
});

function show_server(serverid){
	
	var html =
		'<h2>' + htmlspecialchars(pinged_list[serverid].server.name) + '</h2>' +
		'Description' +
		'<div class="code">' + htmlspecialchars(pinged_list[serverid].server.description) + '</div>';
	
	var url_obj = new URL(pinged_list[serverid].server.ip);
	var url = htmlspecialchars(url_obj.origin);
	var domain = url_obj.hostname;
	
	html +=
		'URL: <a rel="noreferer" target="_BLANK" href="' + url + redir + '">' + url + '</a> <a rel="noreferer" target="_BLANK" href="https://browserleaks.com/ip/' + encodeURIComponent(domain) + '">(IP lookup)</a>' +
		'<br><br>Alt addresses:';
	
	var len = pinged_list[serverid].server.alt_addresses.length;
	
	if(len === 0){
		
		html += ' <i>&lt;Empty&gt;</i>';
	}else{
		
		html += '<ul>';
		
		for(var i=0; i<len; i++){
						
			var url_obj = new URL(pinged_list[serverid].server.alt_addresses[i]);
			var url = htmlspecialchars(url_obj.origin);
			var domain = url_obj.hostname;
			
			if(validate_url(pinged_list[serverid].server.alt_addresses[i], true)){
				
				html += '<li><a rel="noreferer" href="' + url + redir + '" target="_BLANK">' + url + '</a>  <a rel="noreferer" target="_BLANK" href="https://browserleaks.com/ip/' + encodeURIComponent(domain) + '">(IP lookup)</a></li>';
			}else{
				
				console.warn(pinged_list[serverid].server.ip + ": Invalid peer URL => " + pinged_list[serverid].server.alt_addresses[i]);
			}
		}
		
		html += '</ul>';
	}
	popup.innerHTML = html;
	
	popup_wrapper.style.display = "block";
	popup_bg.style.display = "block";
}

function hide_server(){
	
	popup_wrapper.style.display = "none";
	popup_bg.style.display = "none";
}
