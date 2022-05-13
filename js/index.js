$(function () {
	// countries and states
	const _new_question = new New_Question();

	_new_question.add_newfield();
	_new_question.create_newfield();

	const _pdf = new Pdf();

	_pdf.read();

	auto_resize(); // resize a text area
});

const auto_resize = function(_this = ''){
	$("textarea").each(function () {
		if(_this==='')
			this.setAttribute("style", "height:" + (this.scrollHeight) + "px;overflow-y:hidden;");
		else
			$(_this).css({'height': _this.scrollHeight + "px", 'overflow-y': 'hidden'});
	}).on("input", function () {
		_this = _this==='' ? this : _this;

		_this.style.height = "auto";
		_this.style.height = (_this.scrollHeight) + "px";
	});
}

const activate_grade = function(_this){
	const _new_question = new New_Question();

	_new_question.activate_grade(_this);
}

const create_newfield = function(_this){
	const _new_question = new New_Question();

	_new_question.create_newfield(_this);
}