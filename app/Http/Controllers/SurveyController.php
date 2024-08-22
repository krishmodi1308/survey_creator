<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::paginate(10);
        return view('surveys.index', compact('surveys'));
    }

    public function create()
    {
        return view('surveys.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|string|in:text,radio,checkbox',
            'questions.*.options.*' => 'required_if:questions.*.type,radio,checkbox|string'
        ]);
    
        $survey = Survey::create($request->only('name'));
    
        foreach ($request->questions as $questionData) {
            $question = $survey->questions()->create([
                'question_text' => $questionData['text'],
                'type' => $questionData['type'],
            ]);
    
            if (isset($questionData['options'])) {
                foreach ($questionData['options'] as $optionText) {
                    if (!empty($optionText)) {
                        $question->options()->create(['option_text' => $optionText]);
                    }
                }
            }
        }
    
        return redirect()->route('surveys.index')->with('success', 'Survey created successfully.');
    }    

    public function show(Survey $survey)
    {
        return view('surveys.show', compact('survey'));
    }

    public function edit(Survey $survey)
    {
        return view('surveys.edit', compact('survey'));
    }

    public function update(Request $request, Survey $survey)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|string|in:text,radio,checkbox',
            'questions.*.options.*' => 'required_if:questions.*.type,radio,checkbox|string'
        ]);
    
        $survey->update($request->only('name'));
    
        $existingQuestionIds = $survey->questions->pluck('id')->toArray();
    
        foreach ($request->questions as $index => $questionData) {
            if (isset($questionData['id'])) {
                $question = Question::find($questionData['id']);
                if ($question) {
                    $question->update([
                        'question_text' => $questionData['text'],
                        'type' => $questionData['type'],
                    ]);
    
                    if ($question->type === 'radio' || $question->type === 'checkbox') {
                        $question->options()->delete();
    
                        foreach ($questionData['options'] as $optionText) {
                            if (!empty($optionText)) {
                                $question->options()->create(['option_text' => $optionText]);
                            }
                        }
                    }
                    
                    $existingQuestionIds = array_diff($existingQuestionIds, [$question->id]);
                }
            } else {
                $question = $survey->questions()->create([
                    'question_text' => $questionData['text'],
                    'type' => $questionData['type'],
                ]);
    
                if ($question->type === 'radio' || $question->type === 'checkbox') {
                    foreach ($questionData['options'] as $optionText) {
                        if (!empty($optionText)) {
                            $question->options()->create(['option_text' => $optionText]);
                        }
                    }
                }
            }
        }
    
        if (!empty($existingQuestionIds)) {
            Question::whereIn('id', $existingQuestionIds)->delete();
        }
    
        return redirect()->route('surveys.index')->with('success', 'Survey updated successfully.');
    }
    
    

    public function destroy(Survey $survey)
    {
        $survey->delete();
        return redirect()->route('surveys.index')->with('success', 'Survey deleted successfully.');
    }

    public function participate(Survey $survey)
    {
        return view('surveys.participate', compact('survey'));
    }

    public function submit(Request $request, Survey $survey)
    {
        $request->validate([
            'user.name' => 'required|string|max:255',
            'user.age' => 'required|integer|min:0',
            'user.sex' => 'required|string|max:10',
        ]);
    
        $userData = $request->input('user');
    
        $response = $survey->responses()->create([
            'user_name' => $userData['name'],
            'user_age' => $userData['age'],
            'user_sex' => $userData['sex'],
        ]);
    
        foreach ($request->answers as $questionId => $answer) {
            $response->answers()->create([
                'question_id' => $questionId,
                'answer_text' => is_array($answer) ? implode(', ', $answer) : $answer,
            ]);
        }
    
        return redirect()->route('surveys.participate', $survey)->with('success', 'Thank you for your response.');
    }
    
    public function report(Survey $survey)
    {
        $questions = $survey->questions()->with('answers')->get();
        $reportData = [];

        foreach ($questions as $question) {
            $totalResponses = $question->answers->count();
            $answerCounts = [];

            foreach ($question->options as $option) {
                $count = $question->answers->where('answer_text', $option->option_text)->count();
                $percentage = $totalResponses > 0 ? ($count / $totalResponses) * 100 : 0;
                $answerCounts[] = round($percentage, 2) . '%';
            }

            if ($question->type == 'text') {
                $answerCounts[] = '100%';
            }

            $reportData[] = [
                'question' => $question->question_text,
                'type' => $question->type,
                'answers' => $answerCounts
            ];
        }

        return view('surveys.report', compact('reportData'));
    }
    
}
