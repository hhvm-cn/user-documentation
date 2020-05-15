<?hh // strict

namespace HHVM\UserDocumentation\Tests;
use type Facebook\HackTest\{DataProvider, TestGroup};
use function Facebook\FBExpect\expect;

final class HTTPSEnforcementTest extends \Facebook\HackTest\HackTest {
  <<TestGroup('remote')>>
  public async function testNoEnforcementByDefault(): Awaitable<void> {
    list($response, $_) = await PageLoader::getPageAsync(
      'http://example.com/hack/reference/',
    );
    expect($response->getStatusCode())->toBeSame(200);
  }

  public function httpsDomains(): vec<(string)> {
    return vec[tuple('docs.hhvm-cn.com'), tuple('staging.docs.hhvm.com')];
  }

  <<DataProvider('httpsDomains'), TestGroup('remote')>>
  public async function testEnforcedOnDomain(string $domain): Awaitable<void> {
    list($response, $_) = await PageLoader::getPageAsync(
      'http://'.$domain.'/hack/reference/',
    );
    expect($response->getStatusCode())->toBeSame(301);

    $location = $response->getHeaderLine('Location');
    expect($location)->toBeSame('https://'.$domain.'/hack/reference/');

    list($response, $_) = await PageLoader::getPageAsync($location);
    expect($response->getStatusCode())->toBeSame(200);

    $hsts = $response->getHeaderLine('Strict-Transport-Security');
    expect($hsts)->toContainSubstring('max-age=');
    expect($hsts)->toNotBeSame('max-age=0');
  }

  <<TestGroup('remote')>>
  public async function testNotEnforcedOnRobotsTxt(): Awaitable<void> {
    list($response, $_) = await PageLoader::getPageAsync(
      'https://docs.hhvm-cn.com/robots.txt',
    );
    expect($response->getStatusCode())->toBeSame(200);
  }

  <<TestGroup('remote')>>
  public async function test404Status(): Awaitable<void> {
    list($response, $_) = await PageLoader::getPageAsync(
      'https://docs.hhvm-cn.com/__idonotexist_fortesting',
    );
    expect($response->getStatusCode())->toBeSame(404);
  }
}
