<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use ReallySimpleJWT\Validate;
use ReallySimpleJWT\Parsed;
use ReallySimpleJWT\Jwt;
use ReallySimpleJWT\Token;
use ReallySimpleJWT\Build;
use ReallySimpleJWT\Encode;
use ReallySimpleJWT\Secret;

class ParsedTest extends TestCase
{
    public function testParsedGetJWT(): void
    {
        $parsed = new Parsed(
            new Jwt(
                Token::create(1, 'foo1234He$$llo56', time() + 300, '127.0.0.1'),
                'foo1234He$$llo56'
            ),
            ["typ" => "JWT"],
            ["iss" => "127.0.0.1"],
            'hello'
        );

        $this->assertInstanceOf(Jwt::class, $parsed->getJwt());
    }

    public function testParsedGetHeader(): void
    {
        $parsed = new Parsed(
            new Jwt(
                Token::create(1, 'foo1234He$$llo56', time() + 300, '127.0.0.1'),
                'foo1234He$$llo56'
            ),
            ["typ" => "JWT"],
            ["iss" => "127.0.0.1"],
            'hello'
        );

        $this->assertSame('JWT', $parsed->getHeader()['typ']);
    }

    public function testParsedGetPayload(): void
    {
        $parsed = new Parsed(
            new Jwt(
                Token::create(1, 'foo1234He$$llo56', time() + 300, '127.0.0.1'),
                'foo1234He$$llo56'
            ),
            ["typ" => "JWT"],
            ["iss" => "127.0.0.1"],
            'hello'
        );

        $this->assertSame('127.0.0.1', $parsed->getPayload()['iss']);
    }

    public function testParsedGetSignature(): void
    {
        $parsed = new Parsed(
            new Jwt(
                Token::create(1, 'foo1234He$$llo56', time() + 300, '127.0.0.1'),
                'foo1234He$$llo56'
            ),
            ["typ" => "JWT"],
            ["iss" => "127.0.0.1"],
            'hello'
        );

        $this->assertSame('hello', $parsed->getSignature());
    }

    public function testGetIssuer(): void
    {
        $build = new Build('JWT', new Validate(), new Secret(), new Encode());

        $token = $build->setSecret('foo1234He$$llo56')->setIssuer('localhost')->build();

        $parsed = new Parsed(
            $token,
            ["typ" => "JWT"],
            ["iss" => "localhost"],
            'hello'
        );

        $this->assertSame('localhost', $parsed->getIssuer());
    }

    public function testGetIssuerNotSet(): void
    {
        $build = new Build('JWT', new Validate(), new Secret(), new Encode());

        $token = $build->setSecret('foo1234He$$llo56')->setIssuer('localhost')->build();

        $parsed = new Parsed(
            $token,
            ["typ" => "JWT"],
            ["iat" => 123],
            'hello'
        );

        $this->assertSame('', $parsed->getIssuer());
    }

    public function testGetSubject(): void
    {
        $build = new Build('JWT', new Validate(), new Secret(), new Encode());

        $token = $build->setSecret('foo1234He$$llo56')->setIssuer('localhost')->build();

        $parsed = new Parsed(
            $token,
            ["typ" => "JWT"],
            ["sub" => "payments"],
            'hello'
        );

        $this->assertSame('payments', $parsed->getSubject());
    }

    public function testGetSubjectNotSet(): void
    {
        $build = new Build('JWT', new Validate(), new Secret(), new Encode());

        $token = $build->setSecret('foo1234He$$llo56')->setIssuer('localhost')->build();

        $parsed = new Parsed(
            $token,
            ["typ" => "JWT"],
            ["iat" => 123],
            'hello'
        );

        $this->assertSame('', $parsed->getSubject());
    }

    public function testGetAudience(): void
    {
        $build = new Build('JWT', new Validate(), new Secret(), new Encode());

        $token = $build->setSecret('foo1234He$$llo56')->setIssuer('localhost')->build();

        $parsed = new Parsed(
            $token,
            ["typ" => "JWT"],
            ["aud" => "users"],
            'hello'
        );

        $this->assertSame('users', $parsed->getAudience());
    }

    public function testGetAudienceIsArray(): void
    {
        $build = new Build('JWT', new Validate(), new Secret(), new Encode());

        $token = $build->setSecret('foo1234He$$llo56')->setIssuer('localhost')->build();

        $parsed = new Parsed(
            $token,
            ["typ" => "JWT"],
            ["aud" => ["users", "admins"]],
            'hello'
        );

        $this->assertSame('users', $parsed->getAudience()[0]);
        $this->assertSame('admins', $parsed->getAudience()[1]);
    }

    public function testGetAudienceNotSet(): void
    {
        $build = new Build('JWT', new Validate(), new Secret(), new Encode());

        $token = $build->setSecret('foo1234He$$llo56')->setIssuer('localhost')->build();

        $parsed = new Parsed(
            $token,
            ["typ" => "JWT"],
            ["iat" => 123],
            'hello'
        );

        $this->assertSame('', $parsed->getAudience());
    }

    public function testGetExpiration(): void
    {
        $build = new Build('JWT', new Validate(), new Secret(), new Encode());

        $token = $build->setSecret('foo1234He$$llo56')->setIssuer('localhost')->build();

        $parsed = new Parsed(
            $token,
            ["typ" => "JWT"],
            ["exp" => 123456],
            'hello'
        );

        $this->assertSame(123456, $parsed->getExpiration());
    }

    public function testGetExpirationNotSet(): void
    {
        $build = new Build('JWT', new Validate(), new Secret(), new Encode());

        $token = $build->setSecret('foo1234He$$llo56')->setIssuer('localhost')->build();

        $parsed = new Parsed(
            $token,
            ["typ" => "JWT"],
            ["iat" => 123],
            'hello'
        );

        $this->assertSame(0, $parsed->getExpiration());
    }

    public function testGetNotBefore(): void
    {
        $build = new Build('JWT', new Validate(), new Secret(), new Encode());

        $token = $build->setSecret('foo1234He$$llo56')->setIssuer('localhost')->build();

        $parsed = new Parsed(
            $token,
            ["typ" => "JWT"],
            ["nbf" => 123456],
            'hello'
        );

        $this->assertSame(123456, $parsed->getNotBefore());
    }

    public function testGetNotBeforeNotSet(): void
    {
        $build = new Build('JWT', new Validate(), new Secret(), new Encode());

        $token = $build->setSecret('foo1234He$$llo56')->setIssuer('localhost')->build();

        $parsed = new Parsed(
            $token,
            ["typ" => "JWT"],
            ["iat" => 123],
            'hello'
        );

        $this->assertSame(0, $parsed->getNotBefore());
    }

    public function testGetIssuedAt(): void
    {
        $build = new Build('JWT', new Validate(), new Secret(), new Encode());

        $token = $build->setSecret('foo1234He$$llo56')->setIssuer('localhost')->build();

        $parsed = new Parsed(
            $token,
            ["typ" => "JWT"],
            ["iat" => 123456],
            'hello'
        );

        $this->assertSame(123456, $parsed->getIssuedAt());
    }

    public function testGetIssuedAtNotSet(): void
    {
        $build = new Build('JWT', new Validate(), new Secret(), new Encode());

        $token = $build->setSecret('foo1234He$$llo56')->setIssuer('localhost')->build();

        $parsed = new Parsed(
            $token,
            ["typ" => "JWT"],
            ["exp" => 123],
            'hello'
        );

        $this->assertSame(0, $parsed->getIssuedAt());
    }

    public function testGetJwtId(): void
    {
        $build = new Build('JWT', new Validate(), new Secret(), new Encode());

        $token = $build->setSecret('foo1234He$$llo56')->setIssuer('localhost')->build();

        $parsed = new Parsed(
            $token,
            ["typ" => "JWT"],
            ["jti" => "he6236Yui"],
            'hello'
        );

        $this->assertSame('he6236Yui', $parsed->getJwtId());
    }

    public function testGetJwtIdNotSet(): void
    {
        $build = new Build('JWT', new Validate(), new Secret(), new Encode());

        $token = $build->setSecret('foo1234He$$llo56')->setIssuer('localhost')->build();

        $parsed = new Parsed(
            $token,
            ["typ" => "JWT"],
            ["iat" => 123],
            'hello'
        );

        $this->assertSame('', $parsed->getJwtId());
    }

    public function testGetAlgorithm(): void
    {
        $build = new Build('JWT', new Validate(), new Secret(), new Encode());

        $token = $build->setSecret('foo1234He$$llo56')->setIssuer('localhost')->build();

        $parsed = new Parsed(
            $token,
            ["typ" => "JWT", "alg" => "HS256"],
            ["jti" => "he6236Yui"],
            'hello'
        );

        $this->assertSame('HS256', $parsed->getAlgorithm());
    }

    public function testGetType(): void
    {
        $build = new Build('JWT', new Validate(), new Secret(), new Encode());

        $token = $build->setSecret('foo1234He$$llo56')->setIssuer('localhost')->build();

        $parsed = new Parsed(
            $token,
            ["typ" => "JWT"],
            ["jti" => "he6236Yui"],
            'hello'
        );

        $this->assertSame('JWT', $parsed->getType());
    }

    public function testGetTypeNotSet(): void
    {
        $build = new Build('JWT', new Validate(), new Secret(), new Encode());

        $token = $build->setSecret('foo1234He$$llo56')->setIssuer('localhost')->build();

        $parsed = new Parsed(
            $token,
            ["cty" => "nested"],
            ["iat" => 123],
            'hello'
        );

        $this->assertSame('', $parsed->getType());
    }

    public function testGetContentType(): void
    {
        $build = new Build('JWT', new Validate(), new Secret(), new Encode());

        $token = $build->setSecret('foo1234He$$llo56')->setIssuer('localhost')->build();

        $parsed = new Parsed(
            $token,
            ["cty" => "nested"],
            ["jti" => "he6236Yui"],
            'hello'
        );

        $this->assertSame('nested', $parsed->getContentType());
    }

    public function testGetContentTypeNotSet(): void
    {
        $build = new Build('JWT', new Validate(), new Secret(), new Encode());

        $token = $build->setSecret('foo1234He$$llo56')->setIssuer('localhost')->build();

        $parsed = new Parsed(
            $token,
            ["typ" => "JWT"],
            ["iat" => 123],
            'hello'
        );

        $this->assertSame('', $parsed->getContentType());
    }

    public function testGetExpiresIn(): void
    {
        $build = new Build('JWT', new Validate(), new Secret(), new Encode());

        $token = $build->setSecret('foo1234He$$llo56')->setIssuer('localhost')->build();

        $time = time() + 300;

        $parsed = new Parsed(
            $token,
            ["typ" => "JWT"],
            ["exp" => $time],
            'hello'
        );

        $result = $parsed->getExpiresIn();

        $this->assertTrue(300 === $result || 299 === $result);
    }

    public function testGetExpiresInNegative(): void
    {
        $build = new Build('JWT', new Validate(), new Secret(), new Encode());

        $token = $build->setSecret('foo1234He$$llo56')->setIssuer('localhost')->build();

        $time = time() - 100;

        $parsed = new Parsed(
            $token,
            ["typ" => "JWT"],
            ["exp" => $time],
            'hello'
        );

        $this->assertSame(0, $parsed->getExpiresIn());
    }

    public function testGetUsableIn(): void
    {
        $build = new Build('JWT', new Validate(), new Secret(), new Encode());

        $token = $build->setSecret('foo1234He$$llo56')->setIssuer('localhost')->build();

        $time = time() + 200;

        $parsed = new Parsed(
            $token,
            ["typ" => "JWT"],
            ["nbf" => $time],
            'hello'
        );

        $result = $parsed->getUsableIn();

        $this->assertTrue(200 === $result || 199 === $result);
    }

    public function testGetUsableInNegative(): void
    {
        $build = new Build('JWT', new Validate(), new Secret(), new Encode());

        $token = $build->setSecret('foo1234He$$llo56')->setIssuer('localhost')->build();

        $time = time() - 100;

        $parsed = new Parsed(
            $token,
            ["typ" => "JWT"],
            ["nbf" => $time],
            'hello'
        );

        $this->assertSame(0, $parsed->getUsableIn());
    }
}
