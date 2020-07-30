<?php

namespace Tests\Feature;

use App\Entities\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{

    use RefreshDatabase;

    protected $comment;

//    public function setUp() :void
//    {
//        parent::setUp();
//        $this->comment = factory(Comment::class)->create();
//
//    }

    public function test_check_is_data_exists_in_db()
    {
        $comment = factory(Comment::class)->create();

        $this->assertDatabaseHas('comments', [
            'body' => $comment->body,
        ]);
    }


    public function test_user_can_post_a_new_comment()
    {
        $data = [
            'body' => 'test user comment',
        ];

        $this->json('POST', route('comment.store'), $data)
            ->assertStatus(201);

        $this->assertEquals(1, Comment::all()->count());
        $comment = Comment::first();
        $this->assertEquals($data['body'], $comment->body);

    }

    public function test_user_can_reply_to_comment()
    {
        $comment = factory(Comment::class)->create();

        $replyData = [
            'body' => 'test reply comment',
            'parent_id' => $comment->id,
        ];

        $this->json('POST', route('comment.store'), $replyData)
            ->assertStatus(201);

        $this->assertEquals(2, Comment::all()->count());
        $this->assertEquals(1, $comment->replies()->count());
        $reply = $comment->replies()->first();
        $this->assertEquals('test reply comment', $reply->body);
    }

    public function test_user_try_to_add_reply_to_not_exists_comment()
    {
        $comment = factory(Comment::class)->create();

        $replyData = [
            'body' => 'test reply comment',
            'parent_id' => 19,
        ];

        $this->json('POST', route('comment.store'), $replyData)
            ->assertStatus(422);

        $this->assertEquals(1, Comment::all()->count());
        $this->assertEquals(0, $comment->replies()->count());

    }

    public function test_user_can_get_replies_belongs_to_comment()
    {
        $this->withoutExceptionHandling();
        $commentOne = factory(Comment::class)->create();
        $commentTwo = factory(Comment::class)->create();

        //create replies to first comment

        $replyOne = factory(Comment::class)->create([
            'parent_id' => $commentOne->id
        ]);

        $replyTwo = factory(Comment::class)->create([
            'parent_id' => $commentOne->id
        ]);


        $response = $this
            ->json('GET', route('comment.index'))
            ->assertOk();


        $this->assertCount(2, $response->json());

        $response->assertJson([
            [
                'id' => $commentOne->id,
                'replies' =>
                    [
                        ['id' => $replyOne->id],
                        ['id' => $replyTwo->id],
                    ]
            ],
            [
                'id' => $commentTwo->id,
                'replies' => []
            ]
        ]);

    }

    public function test_user_can_update_comment()
    {
        $comment = factory(Comment::class)->create();

        $data = [
            'body' => 'Updated comment'
        ];

        $this->json('PATCH', route('comment.update', $comment->id), $data)
            ->assertSuccessful();

        $updatedComment = Comment::first();

        $this->assertEquals($data['body'], $updatedComment->body);
    }


    public function test_user_can_delete_comment()
    {
        $comment = factory(Comment::class)->create();

        $this->json('DELETE', route('comment.destroy', $comment->id))
            ->assertStatus(200);

        $this->json('DELETE', route('comment.destroy', $comment->id))
            ->assertStatus(404);
    }

    public function test_validation_required_body_field_in_new_comment()
    {

        $this->json('POST', route('comment.store'), [
            'body' => '',
        ])
            ->assertStatus(422);

    }

    public function test_validation_required_body_field_contains_at_least_5_characters()
    {

        $this->json('POST', route('comment.store'), [
            'body' => 'test',
        ])
            ->assertStatus(422);

    }

    public function test_validation_parent_id_field_is_an_integer_not_negative_and_not_array()
    {

        $this->json('POST', route('comment.store'), [
            'body' => 'test user comment',
            'parent_id' => 'not integer'
        ])
            ->assertStatus(422);

        $this->json('POST', route('comment.store'), [
            'body' => 'test user comment',
            'parent_id' => -5
        ])
            ->assertStatus(422);

        $this->json('POST', route('comment.store'), [
            'body' => 'test user comment',
            'parent_id' => [7]
        ])
            ->assertStatus(422);

    }

}
