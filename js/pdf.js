class Pdf{
	construct(){

	}

	read(){
		$('#submit').click(function () {
			const _pdf = new Pdf();

			_pdf.print();
		});
	}

	print(for_student = true){
		let sel_tohide = (for_student ? '.teacher-view, ' : '') + '.no-show';
		$(sel_tohide).addClass('d-none');

		if(for_student){
			$('.student-view').removeClass('d-none');
		}

		const _new_question = new New_Question();

		_new_question.hide_emptyfields();
		_new_question.hide_emptysections();
		_new_question.replace_textarea();

		var pdf = new jsPDF('p', 'pt', 'letter');

		pdf.html(document.getElementById('page-content'), {
			callback: function (pdf) {
				var options = {
			        pagesplit: true
			    };

				let blob = pdf.output('blob', options);

				let filename = (for_student ? 'student' : 'teacher') + '.pdf';

				pdf.save(filename);
				// window.open(URL.createObjectURL(blob));

				$(sel_tohide).removeClass('d-none');

				_new_question.hide_emptyfields(false);
				_new_question.hide_emptysections(false);
				_new_question.replace_textarea(false);

				if(for_student){
					$('.student-view').addClass('d-none');
					
					const _pdf = new Pdf();

					_pdf.print(false);
				}
			},
			// autoPaging: 'text',
			x: 10,
			y: 10,
			width: 590,
			windowWidth: document.documentElement.clientWidth
		});
	}
}