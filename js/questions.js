var questionsArray = [];

function addAnswer(type, parent, answerId, questionId) {
    var container = $('<div id="answerContainer-'+answerId+'" class="answerContainer"></div>').appendTo(parent);
    var fullIdentifier = 'ans-' + questionId + '-' + answerId;
    var inputType = undefined;
    if (type == 'check') {
        inputType = 'checkbox';
    }
    else if (type == 'radio') {
        inputType = 'radio';
    }
    if (inputType !== undefined) {
        container.append('<input class="'+inputType+'Answer" type="'+inputType+'"/>');
        container.append('<input type="text" name="'+fullIdentifier+'" placeholder="Opcija '+answerId+'"/>');
    }
    else if (type == 'text') {
        container.append('<input data-qid="'+questionId+'" class="textAnswer" name="'+fullIdentifier+'" type="text"/>');
    }
    if (type != 'text') {
        container.append('<button type="button" data-aid="'+answerId+'" id="removeAnswer-'+answerId+'">Remove answer</button>');
        $('#removeAnswer-'+answerId).on('click', function(e) {
            e.preventDefault();
            var answerId = $(this).attr('data-aid');
            var container = $('#answerContainer-'+answerId);
            container.remove();
        });
    }
}

function addQuestion() {

}

$(document).ready(function() {
    $('#questionType').on('change', function(e) {
        var questionType = $('option:selected', $(this)).val();
        var answerSheet = $('#answerSheet');
        var parent = $(this).parent();
        var questionId = $(parent).attr('data-qid');
        answerSheet.empty();
        
        addAnswer(questionType, answerSheet, 1, questionId);
    });
});