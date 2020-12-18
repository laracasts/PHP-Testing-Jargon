<?php

namespace Tests;

use App\Question;
use App\Quiz;
use PHPUnit\Framework\TestCase;

class QuizTest extends TestCase
{
    protected Quiz $quiz;

    public function setUp(): void
    {
        $this->quiz = new Quiz();
    }

    /** @test */
    public function it_consists_of_questions()
    {
        $this->quiz->addQuestion(new Question("What is 2 + 2?", 4));

        $this->assertCount(1, $this->quiz->questions());
    }

    /** @test */
    public function it_grades_a_perfect_quiz()
    {
        $this->quiz->addQuestion(new Question("What is 2 + 2?", 4));

        $this->quiz->begin()->answer(4);

        $this->assertEquals(100, $this->quiz->grade());
    }

    /** @test */
    public function it_grades_a_failed_quiz()
    {
        $this->quiz->addQuestion(new Question("What is 2 + 2?", 4));

        $this->quiz->nextQuestion()->answer("incorrect answer");

        $this->assertEquals(0, $this->quiz->grade());
    }

    /** @test */
    public function it_correctly_tracks_the_next_question_in_the_queue()
    {
        $this->quiz->addQuestion($question1 = new Question("What is 2 + 2?", 4));
        $this->quiz->addQuestion($question2 = new Question("What is 3 + 3?", 6));

        $this->assertEquals($question1, $this->quiz->nextQuestion());
        $this->assertEquals($question2, $this->quiz->nextQuestion());
    }

    /** @test */
    public function it_returns_false_if_there_are_no_remaining_next_questions()
    {
        $this->quiz->addQuestion($question1 = new Question("What is 2 + 2?", 4));

        $this->quiz->nextQuestion();

        $this->assertFalse($this->quiz->nextQuestion());
    }

    /** @test */
    public function it_cannot_be_graded_until_all_questions_have_been_answered()
    {
        $this->quiz->addQuestion(new Question("What is 2 + 2?", 4));

        $this->expectException(\Exception::class);

        $this->quiz->grade();
    }

    /** @test */
    public function it_knows_if_it_is_complete()
    {
        $this->quiz->addQuestion(new Question("What is 2 + 2?", 4));

        $this->assertFalse($this->quiz->isComplete());

        $this->quiz->nextQuestion()->answer(4);

        $this->assertTrue($this->quiz->isComplete());
    }
}
