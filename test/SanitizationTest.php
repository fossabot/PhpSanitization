<?php

namespace PhpSanitization\PhpSanitization\Test;

use PhpSanitization\PhpSanitization\Sanitization;
use PHPUnit\Framework\TestCase;

class SanitizationTest extends TestCase
{
    public function testCheckIfTheLibrarySanitizeString()
    {
        $sanitizer = new Sanitization();
        $sanitized = $sanitizer->useSanitize("<script>alert('xss');</script>");
        $expected = "&lt;script&gt;alert(&#039;xss&#039;);&lt;/script&gt;";

        $this->assertEquals($expected, $sanitized);
    }

    public function testCheckIfTheLibrarySanitizeArray()
    {
        $sanitizer = new Sanitization();
        $sanitized = $sanitizer->useSanitize(["<script>alert('xss');</script>"]);
        $expected[0] = "&lt;script&gt;alert(&#039;xss&#039;);&lt;/script&gt;";

        $this->assertEquals($expected[0], $sanitized[0]);
    }

    public function testCheckIfTheLibrarySanitizeAssociativeArrayValues()
    {
        $sanitizer = new Sanitization();
        $sanitized = $sanitizer->useSanitize(["xss" => "<script>alert('xss');</script>"]);
        $expected["xss"] = "&lt;script&gt;alert(&#039;xss&#039;);&lt;/script&gt;";

        $this->assertEquals($expected["xss"], $sanitized["xss"]);
    }

    public function testCheckIfTheLibrarySanitizeAssociativeArrayKeys()
    {
        $sanitizer = new Sanitization();
        $sanitized = $sanitizer->useSanitize(["sql'" => "xss"]);
        $expected["sql&#039;"] = "xss";

        $this->assertEquals(
            $expected["sql&#039;"],
            $sanitized["sql&#039;"]
        );
    }

    public function testCheckIfTheLibraryIdentiftyEmptyString()
    {
        $sanitizer = new Sanitization();
        $sanitized = $sanitizer->useSanitize("");
        $expected = false;

        $this->assertEquals($expected, $sanitized);
    }

    public function testCheckIfTheLibraryIdentiftyEmptyArray()
    {
        $sanitizer = new Sanitization();
        $sanitized = $sanitizer->useSanitize([]);
        $expected = false;

        $this->assertEquals($expected, $sanitized);
    }

    public function testCheckIfTheLibraryIdentiftyEmptyQuery()
    {
        $sanitizer = new Sanitization();
        $sanitized = $sanitizer->useEscape("");
        $expected = false;

        $this->assertEquals($expected, $sanitized);
    }

    public function testCheckIfTheLibraryEscapeSqlQueries()
    {
        $sanitizer = new Sanitization();
        $escaped = $sanitizer->useEscape(
            "SELECT * FROM 'users' WHERE username = 'admin';"
        );
        $expected = "SELECT * FROM \'users\' WHERE username = \'admin\';";

        $this->assertEquals(
            $expected,
            $escaped
        );
    }

    public function testCheckIfUseTrimWorks()
    {
        $sanitizer = new Sanitization();
        $escaped = $sanitizer->useTrim(" This is a text ");
        $expected = "This is a text";

        $this->assertEquals(
            $expected,
            $escaped
        );
    }

    public function testCheckIfUseHtmlEntitiesWorks()
    {
        $sanitizer = new Sanitization();
        $escaped = $sanitizer->useHtmlEntities("<script>alert('This is js code');</script>");
        $expected = "&lt;script&gt;alert(&#039;This is js code&#039;);&lt;/script&gt;";

        $this->assertEquals(
            $expected,
            $escaped
        );
    }

    public function testCheckIfUseFilterVarWorks()
    {
        $sanitizer = new Sanitization();
        $escaped = $sanitizer->useFilterVar("This is a string");
        $expected = "This is a string";

        $this->assertEquals(
            $expected,
            $escaped
        );
    }

    public function testCheckIfUseStripTagsWorks()
    {
        $sanitizer = new Sanitization();
        $escaped = $sanitizer->useStripTags("<script>alert('This is js code');</script>");
        $expected = "alert('This is js code');";

        $this->assertEquals(
            $expected,
            $escaped
        );
    }

    public function testCheckIfUseStripSlashesWorks()
    {
        $sanitizer = new Sanitization();
        $escaped = $sanitizer->useStripSlashes("C:\Users\Faris\Music");
        $expected = "C:UsersFarisMusic";

        $this->assertEquals(
            $expected,
            $escaped
        );
    }

    public function testCheckIfUseHtmlSpecialCharsWorks()
    {
        $sanitizer = new Sanitization();
        $escaped = $sanitizer->useHtmlSpecialChars("<script>alert('This is js code');</script>");
        $expected = "&lt;script&gt;alert(&#039;This is js code&#039;);&lt;/script&gt;";

        $this->assertEquals(
            $expected,
            $escaped
        );
    }
}
