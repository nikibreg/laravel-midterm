<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $canEditQuestions = Gate::allows('edit-questions');
        
        $questions = Question::orderBy('created_at', 'asc')->get();

        return view('questions.index', [
            'questions' => $questions,
            'canEditQuestion' => $canEditQuestions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $canEditQuestions = Gate::allows('edit-questions');
        if(!$canEditQuestions) 
            dd();
        
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required'],
            'correct_answer' => ['required'],
            'incorrect_answer_1' => ['required'],
            'incorrect_answer_2' => ['required'],
            'incorrect_answer_3' => ['required'],
        ]);
        
        $canEditQuestions = Gate::allows('edit-questions');
        if(!$canEditQuestions) 
            dd();
        $question = new Question;
        $question->title = $request->title;

        $correctAnswer = new Answer;
        $correctAnswer->title = $request->correct_answer;
        $correctAnswer->is_correct = true;

        $incorrectAnswer1 = new Answer;
        $incorrectAnswer1->title = $request->incorrect_answer_1;
        $incorrectAnswer1->is_correct = false;

        $incorrectAnswer2 = new Answer;
        $incorrectAnswer2->title = $request->incorrect_answer_2;
        $incorrectAnswer2->is_correct = false;
        
        $incorrectAnswer3 = new Answer;
        $incorrectAnswer3->title = $request->incorrect_answer_3;
        $incorrectAnswer3->is_correct = false;

        $question->save();
        
        $question->answers()->save($correctAnswer);
        $question->answers()->save($incorrectAnswer1);
        $question->answers()->save($incorrectAnswer2);
        $question->answers()->save($incorrectAnswer3);

        $question->save();
        return redirect('/questions');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::findOrFail($id);
        return view('questions.single', [
            'question' => $question,
            'correctAnswer' => $question->correctAnswer()->title,
            'incorrectAnswer1' => $question->incorrectAnswers()->get(1)->title,
            'incorrectAnswer2' => $question->incorrectAnswers()->get(2)->title,
            'incorrectAnswer3' => $question->incorrectAnswers()->get(3)->title
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     if(!$canEditQuestions) 
    //         dd();
    //     $question = Question::findOrFail($id);
    //     $tags = Tag::orderBy('created_at', 'asc')->get();
    //     return view('questions.update', [
    //         'question' => $question,
    //         'tags' => $tags,
    //     ]);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     if(!$canEditQuestions) 
    //         dd();
    //     $question = Question::findOrFail($id);
    //     $question->title = $request->title;
    //     $question->text = $request->text;
    //     $question->likes = $request->likes;
    //     $question->tags()->sync($request->tags);
    //     $question->save();
    //     return redirect('/questions');
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $canEditQuestions = Gate::allows('edit-questions');
        if(!$canEditQuestions) 
            dd();
        $question = Question::findOrFail($id);
        $question->answers->each->delete();
        $question->delete();
        return redirect('/');
    }

      /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showQuiz()
    {
        $questions = Question::inRandomOrder()->limit(3)->get();
        return view('questions.quiz', [
            'questions' => $questions,
        ]);
    }


    public function submitQuiz(Request $request)
    {
        $questions = collect($request->questions)->map(function($question){
            return Question::findOrFail($question['id']);
        });
        $answers = collect($request->questions)->map(function($question){
            return $question['answer'];
        });
        return view('questions.results', [
            'questions' => $questions,
            'answers' => $answers
        ]);
    }


     /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showResults($questions)
    {
        $questions = Question::inRandomOrder()->limit(3)->get();
        return view('questions.quiz', [
            'questions' => $questions,
        ]);
    }
}
