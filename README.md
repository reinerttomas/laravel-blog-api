# Laravel Blog API

This project shows how to create APIs in Laravel for a blog application.

## Features

* ✅ Laravel 11
* ✅ API documentation with [Scramble](https://scramble.dedoc.co/)
* ✅ Enums
* ✅ Laravel Data (Data Transfer Objects)
* ✅ Actions
* ✅ Custom query builders
* ✅ PHPStan
* ✅ Rector
* ✅ Laravel Pint (PHP Coding Standards Fixer)
* ✅ Pest (testing)

## Goals
- [x] user can login
- [x] user can see posts and comments
- [x] user can create a post
- [x] user can update a post
- [x] user can delete a post
- [x] user can create a comment
- [x] user can update a comment
- [x] user can delete a comment
- [x] use `PATCH` request for partial update
- [ ] user can like a post
- [ ] user can dislike a post
- [ ] user can manage their posts and comments
- [ ] use [Laravel Query Builder](https://spatie.be/docs/laravel-query-builder/v5/features/filtering)

## Installation

Install dependencies using Composer

```
composer install
```

Create your .env file from example

```
cp .env.example .env
```

## API documentation

Documentation is generated with [Scramble](https://scramble.dedoc.co/). You can see it at:

```
https://example.test/docs/api
```

## Enums

Enums are a way to define a set of named constants. It is very powerful and can help you write more readable and maintainable code.

```php
enum PostStatus: int
{
    case Draft = 1;
    case Published = 2;
    case Archived = 3;

    public function isDraft(): bool
    {
        return $this === self::Draft;
    }

    public function isPublished(): bool
    {
        return $this === self::Published;
    }

    public function isArchived(): bool
    {
        return $this === self::Archived;
    }

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Published => 'Published',
            self::Archived => 'Archived',
        };
    }
}
```

## Data transfer objects

Data transfer objects (DTOs) are objects that carry data between processes. Package [spatie/laravel-data](https://spatie.be/docs/laravel-data/v4/introduction) provides a simple way to create data transfer objects in Laravel.

```php
#[MapOutputName(SnakeCaseMapper::class)]
final class PostPayload extends Data
{
    public function __construct(
        public readonly string|Optional $title,
        public readonly string|Optional $content,
        public readonly string|Optional $status,
    ) {}
}
```

## Actions

Actions in Laravel are separate classes that encapsulate one specific task or part of the business logic of an application. They are part of a concept that seeks to improve code organization and adhere to the Single Responsibility Principle.

Action class should have one public method execute, run, handle. The name is up to you.

### Create access token

Verify login credentials and create an access token. It returns token as value object.

```php
final readonly class CreateAccessTokenAction
{
    public function execute(User $user): AccessTokenData
    {
        $expiresAt = CarbonImmutable::now()->addHours(2);

        $token = $user->createToken(
            name: 'AccessToken',
            expiresAt: $expiresAt,
        );

        $accessToken = str($token->plainTextToken)->explode('|')->last();

        return new AccessTokenData($accessToken, $expiresAt);
    }
}
```

## Custom query builders

Personally, I don't really like the scope inside the models. A simple solution is a custom query builder.

### User builder

#### In model:

```php
final class User extends Model
{
    // ...
    
    public function newEloquentBuilder($query): UserBuilder
    {
        return new UserBuilder($query);
    }
    
    // ...
}
```

#### Custom query builder:

```php
/**
 * @extends Builder<\App\Models\User>
 */
final class UserBuilder extends Builder
{
    public function whereEmail(string $email): self
    {
        return $this->where('email', $email);
    }
}
```

## Testing

For tests, it uses a [pestphp](https://pestphp.com/). Several tests are created for each endpoint to ensure proper functioning. I'll just give you a few examples.

### Login

```php
it('can login by email and password', function (): void {
    // Arrange
    $user = User::factory()->create();

    $data = [
        'email' => $user->email,
        'password' => 'password',
    ];

    // Act & Assert
    postJson('api/auth/login', $data)
        ->assertStatus(201)
        ->assertJsonStructure(AccessTokenApiStructure::resource());
});

it('returns 422 if invalid credentials', function (array $data): void {
    // Arrange
    User::factory()->create([
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    // Act & Assert
    postJson('api/auth/login', $data)
        ->assertStatus(422)
        ->assertJsonValidationErrors([
            'email' => [
                'The provided credentials are incorrect.',
            ],
        ]);
})->with([
    fn (): array => [
        'email' => 'wrong-email@example.com',
        'password' => 'password',
    ],
    fn (): array => [
        'email' => 'test@example.com',
        'password' => 'wrong-password',
    ],
]);
```

### Post

```php
it('returns paginated list of posts', function (): void {
    // Arrange
    actingAs(User::factory()->create());

    Post::factory()->count(10)->create();

    // Act & Assert
    getJson('api/posts')
        ->assertStatus(200)
        ->assertJsonCount(10, 'data')
        ->assertJsonStructure(PaginatedApiStructure::of(
            PostApiStructure::collection()
        ));
});

it('returns a post', function (): void {
    // Arrange
    actingAs(User::factory()->create());

    $post = Post::factory()->create();

    // Assert & Act
    getJson('api/posts/' . $post->id)
        ->assertStatus(200)
        ->assertJsonStructure(PostApiStructure::resource());
});

it('can publish a post', function (Dataset $dataset): void {
    // Arrange
    actingAs(User::factory()->create());

    $post = Post::factory()->create();

    // Assert & Act
    $response = patchJson('api/posts/' . $post->id, $dataset->data)
        ->assertStatus(200)
        ->assertJsonStructure(PostApiStructure::resource());

    expect($response->json())
        ->status->toBe(PostStatus::Published->value)
        ->publishedAt->not->toBeNull();
})->with([
    fn (): Dataset => new Dataset(data: [
        'status' => PostStatus::Published,
    ]),
]);
```
