//$(document).ready(function(){
	var taskList=null;
	var fakedata = [];
	var autoCompleteTaskName = {
			source: fakedata,
			delay: 1000,
			search: function(event, ui) {
				var input = $(this);
				updateTask(input.closest(".taskContainer").find("input[name=taskid]").val(), input.val(), "taskname");
			},
			change: function(event, ui) {
				var input = $(this);
				var id = input.closest(".taskContainer").find("input[name=taskid]").val();
				if(findTaskValueFromJSON(id, "taskname")!=input.val()){
					updateTask(id, input.val(), "taskname");
				}
			}
		};
	$("input[name=update]").live("click",function(){
		var input = $(this);
		updateTask(input.parent().find("input[name=taskid]").val(), input.parent().find("input[name=taskname]").val(), "taskname");
	});
	
	$.post("jsp/taskPage.php","editType=L",function(response){
		taskList = $.parseJSON(response.replace(/"/g, "").replace(/\\/g, "\"").replace(/"""/g, "\"").replace(/\]"/g, "\]").replace(/"\[/g, "\["));
		$.each(taskList, function(index,obj){
			var columns = $(".column");
			var portlet = $('<div class="portlet"></div>');
			$(columns[obj.positionX-1]).append(portlet);
			portlet.append('<div class="portlet-header"><input type="hidden" value="'+obj.id+'" name="categoryId"/>Category - '+obj.categoryname+'</div>');
			portlet.append('<div class="portlet-content"></div>');
			portlet.find(".portlet-content").append('<div class="tasklistContent"></div>');
			var tasklistContent = portlet.find(".tasklistContent");
			$.each(obj.tasksList, function(index,objTask){
				$cssStatusStrikeThrough = "";
				$cssChecked = "";
				if(objTask.status==1003){//Inactive Task
					return true;
				}else if(objTask.status==1002){//Completed Task
					$cssStatusStrikeThrough = "text-decoration:line-through";
					$cssChecked = ' checked="checked"';
				}
				tasklistContent.append('<div class="taskContainer"><input type="hidden" value="'+objTask.id+'" name="taskid"/><input type="checkbox" name="chkTaskComplete" '+$cssChecked+'/><input type="text" name="taskname" value="'+objTask.taskname+'" class="clsTaskName" style="'+$cssStatusStrikeThrough+'"/><input type="button" name="update" value="update" style="display: none;"/></div>');
			});
			tasklistContent.after('<div><input type="text" name="newtaskname" class="clsNewTask"/> <input type="button" name="btnAddTask" style="display:none;"/></div>');
			
			//Adding the Toolbar to edit the Tasks
			tasklistContent.parent().append('<div style="font-size: 10px;text-align: right;padding-right: 3px;"><button class="btnAddIcon">Add Task</button><button class="btnDeleteIcon">Delete Task</button></div>');
		});
		setPortlets();
		$( ".btnAddIcon" ).button({
			icons: {
				primary: "ui-icon-plus"
			},
			text: false
		});
		$( ".btnDeleteIcon" ).button({
			icons: {
				primary: "ui-icon-trash"
			},
			text: false
		}).click(function(){
			var chkCompleted = $(this).closest(".portlet").find("input[name=chkTaskComplete]:checked");
			$.each(chkCompleted, function(index, chkObj){
				updateTask($(chkObj).parent().find("input[name=taskid]").val(), 1003, "status"); 
				$(chkObj).parent().remove();
			});
		});
		addEventHandlerAfterTaskLoad();
		
		
		$("input[name=taskname]").autocomplete(autoCompleteTaskName);
		$("input[name=newtaskname]").autocomplete({
			source: fakedata,
			delay: 1000,
			search: function(event, ui) {
				var input = $(this);
				addTask(input);
			},
			change: function(event, ui) {
				var input = $(this);
			}
		}).keypress(function(){
			
		});
		  
	});

	$("#btnAddCategory").button().click(function(){
		var addCategoryDialog = $('<div title="Category Name" id="dlgCategoryName"><input type="text" id="txtCategoryName"/></div>');
		addCategoryDialog.dialog({
			"modal": true,
			"resizable": false,
			height: 120,
			show: 'fade',
			hide: "fade",
			create: function(event, ui) {
				//alert(ui);
				$(this).closest(".ui-widget").css({"font-size": "12px"});
			},
			open: function(event, ui) { 
				//$(this).parent().find(".ui-dialog-titlebar").hide();
			},
			close: function(event, ui){
				addCategoryDialog.dialog("destroy").remove();
			},
			buttons:{
				"Add": function(){
					var data = {
						"editType":"A",
						"categoryName": $("#txtCategoryName").val() 
					};
					var columns = $(".column:first");
					var portlet = $('<div class="portlet"></div>');
					$.post("jsp/categoryPage.php",data,function(response){
						portlet.find("input[name=categoryId]").val(response);
						portlet.find(".portlet-header span").text(data.categoryName);
					});
					columns.append(portlet);
					portlet.append('<div class="portlet-header"><input type="hidden" value="0" name="categoryId"/>Category - <span>New</span></div>');
					portlet.append('<div class="portlet-content"></div>');
					portlet.find(".portlet-content").append('<div class="tasklistContent"></div>');
					var tasklistContent = portlet.find(".tasklistContent");
					tasklistContent.after('<div><input type="text" name="newtaskname" /> <input type="button" name="btnAddTask" /></div>');
	
					setPortletDialog(portlet);

					$(this).dialog("close");
				},
				"Cancel": function(){
					$(this).dialog("close");
				}
			}
		});
		return false;
	});
	function addEventHandlerAfterTaskLoad(){
		$("input[name=btnAddTask]").live("click", function(){
			var btnAddTask = $(this);
			var data={
				"categoryId": btnAddTask.closest(".portlet").find("input[name=categoryId]").val(),
				"taskname": btnAddTask.closest(".portlet").find("input[name=newtaskname]").val(),
				"editType": "A"
			};
			$.post("jsp/taskPage.php",data,function(response){
				alert($.parseJSON(response).resp);
			});
		});
		
		$("input[name=chkTaskComplete]").click(function(){
			var checkbox = $(this);
			if(checkbox.is(':checked')){
				checkbox.parent().find('input[name=taskname]').css({"text-decoration":"line-through"});
				//checkbox.closest(".tasklistContent").append(checkbox.parent());
				$completeStatus = 1002;
			}else{
				checkbox.parent().find('input[name=taskname]').css({"text-decoration":""});
				$completeStatus = 1001;
			}
			updateTask(checkbox.parent().find("input[name=taskid]").val(), $completeStatus, "status");
		});
		
		$("input[name=taskname]").dblclick(function(){
			var id = $(this).parent().find("input[name=taskid]").val();
			openAdvancedTaskDlg(id, $(this));
		});
	}
//});
	
function openAdvancedTaskDlg(id, task){
	autoCompleteTaskName;
	var taskDlg = $('<div title="Edit Task" id="dlgTaskEdit"></div>');
	var taskContainer = $('<div class="taskContainer" id="advTaskTaskContainer"></div>');
	var tasknameInput = $('<input name="taskname" type="text"/>');
	taskDlg.append(taskContainer);
	tasknameInput
		.val(task.val())
		.width(275)
		.autocomplete(autoCompleteTaskName)
		.keyup(function(){
			task.val($(this).val());
		})
		.bind('paste', function(e) {
			var el = $(this);
	        setTimeout(function() {
	            task.val($(el).val());
	        }, 100);
		})
		.bind('cut', function(e) {
			var el = $(this);
	        setTimeout(function() {
	            task.val($(el).val());
	        }, 100);
		})
		.appendTo('<div></div>')
			.parent()
			.appendTo(taskContainer);
	taskContainer.append('<div><input type="hidden" name="taskid" value="'+id+'"/><input id="advTaskScheduledDate" type="text"/></div>');
	taskContainer.append('<div><textarea id="advTaskDescription" ></textarea></div>');
	taskDlg.dialog({
		modal: true,
		show: 'fade',
		hide: 'fade',
		height: 200,
		resizable: false,
		close: function(event, ui){
			if(findTaskValueFromJSON(id, "taskname")!=tasknameInput.val()){
				updateTask(id, tasknameInput.val(), "taskname");
			}
			if(findTaskValueFromJSON(id, "taskdescription")!=$("#advTaskDescription").val()){
				updateTask(id, $("#advTaskDescription").val(), "taskdescription");
			}
			taskDlg.dialog("destroy").remove();
		}
	});
	var date = (findTaskValueFromJSON(id, "scheduleddate")!=null) ? Date.parse(findTaskValueFromJSON(id, "scheduleddate")).toString("dd-MMM-yyyy") : "" ;
	$("#advTaskScheduledDate").datepicker({
		dateFormat: "dd-MM-yy",
		minDate: Date.today(),
		changeMonth: true,
		changeYear: true,
		onSelect: function(dateText, inst) {
			updateTask(id, Date.parse(dateText).toString("yyyy-MM-dd"), "scheduleddate");
		}
	}).val(date);
	
	
	$("#advTaskDescription").autocomplete({
		source: fakedata,
		delay: 1000,
		search: function(event, ui) {
			var input = $(this);
			updateTask(id, input.val(), "taskdescription");
		},
		change: function(event, ui) {
			var input = $(this);
			updateTask(id, input.val(), "taskdescription");
		}
	}).val(findTaskValueFromJSON(id, "taskdescription"));
	
	taskDlg.closest(".ui-widget").css({"font-size": "12px"});
}

function updateTaskJSON(taskId, updateFieldValue, property){
	$.each(taskList,function(index, obj){
		$.each(obj.tasksList, function(indexTask, objTask){
			if(objTask.id==taskId){
				objTask[property] = updateFieldValue;
				return false;
			}
		});
	});
}

function addTaskToJSON(input, responseJSON){
	var categoryId = input.closest(".portlet").find("input[name=categoryId]").val();
	var taskName = input.closest(".portlet").find("input[name=newtaskname]").val();
	$.each(taskList,function(index, obj){
		if(obj.id==categoryId){
			obj.tasksList.push(responseJSON);
			return false;
		}
	});
}


function findTaskValueFromJSON(taskId, property){
	var value = "";
	$.each(taskList,function(index, obj){
		$.each(obj.tasksList, function(indexTask, objTask){
			if(objTask.id==taskId){
				value = objTask[property];
				return false;
			}
		});
	});
	return value;
}
	
function updateTask(taskId, updateFieldValue, property){
	updateTaskJSON(taskId, updateFieldValue, getTaskPropertyName.getJSONPropertyName(property).JSONPropertyName);
	var data={
		"taskid": taskId,
		"updateFieldValue": updateFieldValue,
		"property": property,
		"editType": "U"
	};
	$.post("jsp/taskPage.php",data,function(response){
		response;
		//alert($.parseJSON(response).resp);
	});
}


function addTask(input){
	var data={
		"categoryId": input.closest(".portlet").find("input[name=categoryId]").val(),
		"taskname": input.closest(".portlet").find("input[name=newtaskname]").val(),
		"editType": "A"
	};
	$.post("jsp/taskPage.php",data,function(response){
		addTaskToJSON(input, $.parseJSON(response));
	});
}

		
		
		
		
		
		
function setPortlets(){
	$( ".column" ).sortable({
		connectWith: ".column",
		update: function(event, ui) {
			if(ui.sender==null){
				var portlet = ui.item;
				var portletsInColumn = portlet.closest(".column").find(".portlet");
				var positionX = portlet.closest(".column").attr("id").substr(7);
				var positionY = 0;
				$.each(portletsInColumn, function(index,obj){
					if($(portletsInColumn[index]).find("input[name=categoryId]").val()==portlet.find("input[name=categoryId]").val()){
						positionY = index + 1;
					}
				});
				var data={
						"categoryId": portlet.find("input[name=categoryId]").val(),
						"positionX": positionX,
						"positionY": positionY,
						"editType": "P"
					};
				$.post("jsp/categoryPage.php",data,function(response){
					//alert(response);
				});
			}
		}
	});

	setPortletDialog();

	$( "#datepicker" ).datepicker();
}
function setPortletDialog(portlet){
	if(portlet==null || portlet==undefined){
		portlet = $( ".portlet" );
	}
	
	portlet.addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
		.find( ".portlet-header" )
			.addClass( "ui-widget-header ui-corner-all" )
			//.prepend( "<span class='ui-icon ui-icon-minusthick'></span>")
			.end()
		.find( ".portlet-content" );

	portlet.find(".portlet-header .ui-icon").click(function() {
		$( this ).toggleClass( "ui-icon-minusthick" ).toggleClass( "ui-icon-plusthick" );
		$( this ).parents( ".portlet:first" ).find( ".portlet-content" ).toggle();
	});
}


var getTaskPropertyName = {
	getJSONPropertyName: function(property){
		switch (property)
		{
		case "taskname":
			return {"JSONPropertyName": "taskname"};
			break;
		case "scheduleddate":
			return {"JSONPropertyName": "scheduleddate"};
			break;
		case "taskdescription":
			return {"JSONPropertyName": "taskdescription"};
			break;
		case "status":
			return {"JSONPropertyName": "status"};
			break;
		default:
		  document.write("");
		}
	},
	getDBPropertyName: function(property){
		switch (property)
		{
		case "taskname":
			return {"JSONPropertyName": "TASKNAME"};
			break;
		case "scheduleddate":
			return {"DBPropertyName": "SCHEDULEDDATE"};
			break;
		case "taskdescription":
			return {"DBPropertyName": "TASKDESCRIPTION"};
			break;
		case "status":
			return {"JSONPropertyName": "STATUS"};
			break;
		default:
		  document.write("");
		}
	}	
};