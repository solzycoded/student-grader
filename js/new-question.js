class New_Question{
	constructor(){

    }
    
    add_newfield(){
    	$(".create-question").click(function(){
    		let question_template = $('.new-question-template-origo').html();

    		let duplicate_question_template = '<div class="border new-question-template">'+ question_template +'</div><hr>';

    		$('.new-question-template-origo').after(duplicate_question_template);
    	});
    }

    activate_grade(_this){
    	let is_checked = $(_this).prop('checked');
    	let parent = $(_this).next().attr('class');

    	let grades = {'grade-simple': 'warning', 'grade-better': 'primary', 'grade-detailed': 'success', 'grade-failure': 'danger'};

    	let grade_color = grades[parent];

    	parent = $(_this).parent();

    	const _newquestion = new New_Question();

    	_newquestion.toggle_grade(parent, grade_color, is_checked);
    }

    toggle_grade(sel, tagclass, is_checked){
    	tagclass = 'bg-' + tagclass;

    	if(is_checked){
    		sel.addClass(tagclass);
    		sel.next().removeClass('bg-light').addClass(tagclass + ' text-white');
    	}
    	else{
    		sel.removeClass(tagclass);
    		sel.next().addClass('bg-light').removeClass(tagclass + ' text-white');
    	}
    }

    create_newfield(_this){
		let field = '<div class="input-group mb-3 new-question-field">'+$(_this).next().html()+'</div>';

		$(_this).parent().append(field);
    }

    hide_emptyfields(hide = true){
    	$(".new-question-field").each(function () {
    		let checkbox = $(this).children('div').children('input');
    		let is_checked = checkbox.prop('checked');

    		let is_empty = $.trim($(this).children('textarea').val())==='';

    		if(is_empty || !is_checked){
    			let label = $(this).children('div');
    			let textarea = $(this).children('textarea');

    			if(hide){
    				label.addClass('bg-secondary');
    				textarea.removeClass('bg-light').addClass('bg-secondary');
    				// addClass('d-none');
    			}
    			else{
    				label.removeClass('bg-secondary');
    				label.next('textarea').addClass('bg-light').removeClass('bg-secondary');
    				// removeClass('d-none');
    			}
    		}

    		if(hide){
    			checkbox.addClass('d-none');
    		}
			else{
				checkbox.removeClass('d-none');
			}
    	});
    }

    hide_emptysections(hide = true){
    	$(".new-question-header").each(function () {
    		let question_position = $(this).children('.new-question-no');
    		let question_text = $(this).children('.new-question-text');

    		let is_empty = $.trim(question_position.val())==='' || $.trim(question_text.val())==='';

    		if(is_empty){
    			let parent = $(this).parent();
    			let hr = parent.next('hr');

    			if(hide){
    				parent.addClass('d-none');
    				hr.addClass('d-none');
    			}
    			else{
    				parent.removeClass('d-none');
    				hr.removeClass('d-none');
    			}
    		}
    	});
    }

    hide_textarea(hide = true){
    	if(hide)
    		$('textarea').addClass('d-none');
    	else{
    		$('textarea').removeClass('d-none');
    	}
    }
	
	replace_textarea(replace = true){
    	$("textarea").each(function () {
    		let content = $.trim($(this).val());
    		let content_class = $(this).attr('class');

    		if(replace){
    			$(this).addClass('d-none');
    			$(this).after('<div class="border '+content_class+'" style="margin: 0;">'+content+'</div>');
    		}
    		else{
    			$(this).removeClass('d-none');
    			$(this).next('div').remove();
    		}
    	});
	}
}