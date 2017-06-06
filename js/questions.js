var questionsArray = [];
var questionId = 0;
var pollInfo = {
    name: '',
    category: '',
    code: '',
    questions: []
}

function Question(id,type) {
    this.id = id;
    this.type = type;
    this.desc = undefined;//dom
    this.optionNum = 0;
    this.container = undefined;//dom
    this.anon = undefined;//dom
    this.answers = [];
}

function Answer(id,type) {
    this.id = id;
    this.type = type;
    this.desc = undefined;//dom
}

Answer.prototype.appendHtml = function(parent) {
    switch (this.type) {
        case 'text':
            this.desc = $('<input class="textAnswer" type="text"/>').appendTo(parent);
        break;
        case 'radio':
        case 'checkbox':
            $('<input type="'+this.type+'"/>').appendTo(parent);
            this.desc = $('<input type="text" required="required" placeholder="Option '+(this.id+1)+'"/>').appendTo(parent);
            $('<button type="button" class="btn btn-default removeAnswer"><span class="glyphicon glyphicon-minus"></span></button>').appendTo(parent);
        break;
    }
};

function addAnswer(type, parent, questionId) {
    var answerId = questionsArray[questionId].optionNum;
    var container = $('<div data-qid="'+questionId+'" data-aid="'+answerId+'" class="answerContainer"></div>').appendTo(parent);
    questionsArray[questionId].container = container;
    
    var ans = new Answer(answerId, type);
    ans.appendHtml(container);
    questionsArray[questionId].answers.push(ans);
    questionsArray[questionId].optionNum++;
}

function addQuestion(parent) {
    var html = `
    <div class="questionContainer" data-qid="${questionId}">
        <div class="qDetailsContainer">
            <h3>Question No. ${questionId+1}</h3>
            <textarea id="question-${questionId}" rows="5" cols="50"></textarea>
            
            <div data-qid="${questionId}" id="answerSheet-${questionId}"></div>
            <button data-qid="${questionId}" id="addAnswer-${questionId}" type="button" class="addAnswerBtn">Add answer</button>
        </div>
        <div class="qOptionsContainer">
            <h3>Question type</h3>
            <select class="questionType" id="questionType-${questionId}" name="questionType-${questionId}">
                <option value="checkbox">Checkbox</option>
                <option value="radio">Radiobutton</option>
                <option value="text">Text</option>
            </select>
            <h3>Anonymous?</h3>
            <input type="checkbox" id="anon-${questionId}"/>
        </div>
    </div>
    `;
    $(html).appendTo(parent);
    questionsArray[questionId] = new Question(questionId, 'checkbox');
    questionsArray[questionId].desc = $('#question-'+questionId);
    questionsArray[questionId].anon = $('#anon-'+questionId);
    questionId++;
}

$(document).ready(function() {
    var questionsContainer = $('#questionsContainer');
    $('#addQuestionBtn').on('click', function(e) {
        e.preventDefault();
        
        addQuestion(questionsContainer);
    });
    questionsContainer.on('click', '.removeAnswer', function(e) {
        e.preventDefault();
        var container = $(this).parent();
        var qid = container.attr('data-qid');
        var aid = container.attr('data-aid');
        questionsArray[qid].optionNum--;
        questionsArray[qid].answers.splice(aid,1);
        container.remove();
    });
    questionsContainer.on('change', '.questionType', function(e) {
        var parent = $(this).parent().parent();
        var questionId = $(parent).attr('data-qid');
        var answerSheet = $('#answerSheet-'+questionId);
        answerSheet.empty();
        var questionType = $('option:selected', $(this)).val();
        questionsArray[questionId].optionNum = 0;
        questionsArray[questionId].type = questionType;
        questionsArray[questionId].answers = [];
        if (questionType == 'text') {
            $('#addAnswer-'+questionId).hide();
            addAnswer(questionType, $('#answerSheet-'+questionId), questionId)
        }
        else {
            $('#addAnswer-'+questionId).show();
        }
    });
    questionsContainer.on('click', '.addAnswerBtn', function(e) {
        e.preventDefault();
        var qid = $(this).attr('data-qid');
        var questionType = $('option:selected', $('#questionType-'+qid)).val();
        addAnswer(questionType, $('#answerSheet-'+qid), qid);
    });
    $('#quizForm').submit(function (e) {
        e.preventDefault();
        
        var actionurl = e.currentTarget.action;
        
        // resolve dom objects to values
        var i, j;
        for (i = 0; i < questionsArray.length; i++) {
            questionsArray[i].desc = questionsArray[i].desc.val();
            questionsArray[i].anon = questionsArray[i].anon.is(':checked');
            delete questionsArray[i].container;
            for (j = 0; j < questionsArray[i].answers.length; j++) {
                questionsArray[i].answers[j].desc = questionsArray[i].answers[j].desc.val(); 
            }
        }
        
        pollInfo.name = $('#pollName').val();
        pollInfo.category = $('option:selected', $('#pollCategory')).val();
        pollInfo.code = $('#accessCode').val();
        pollInfo.questions = questionsArray;
        
        var json = JSON.stringify(pollInfo);
        
        $.ajax({
                url: actionurl,
                type: 'post',
                dataType:'text',// 'json',
                data: json,
                processData: false,
                contentType: "application/json",
                success: function(data) {
                    if (data['error'] == 'no') {
                        //errorDisplay.hide();
                        //window.location.href = "administration.php";
                    }
                    else {
                        //errorDisplay.set(data['error']);
                    }
                    console.log(data);
                }
        }).fail(function(data,txt,err) {
            //errorDisplay.set('Prijava nije uspjela. Pokušajte ponovno.'); 
            console.log('Server: ' + data.responseText + '; Klijent: ' + txt + ')\n');
        });
    });
});