<?hh // strict

namespace HHVM\UserDocumentation\Tests;
use function Facebook\FBExpect\expect;
use type Facebook\HackTest\{DataProvider, TestGroup};

class SpecialPagesTest extends \Facebook\HackTest\HackTest {
  public function notFoundPathProvider(): vec<(string)> {
    return vec[
      tuple('/_I_DO_NOT_EXIST_FOR_TESTING_'),
      tuple('/manual/en/_I_DO_NOT_EXIST_FOR_TESTING_.php'),
      tuple('/hack/reference/_BAD_DEFINITION_TYPE_FOR_TESTING_/'),
      tuple('/hack/reference/class/_BAD_CLASS_NAME_FOR_TESTING_/'),
    ];
  }

  <<DataProvider('notFoundPathProvider'), TestGroup('remote')>>
  public async function testNotFoundPages(string $path): Awaitable<void> {
    list($response, $body) = await PageLoader::getPageAsync($path);
    expect($response->getStatusCode())->toBeSame(404);
    expect($body)->toContainSubstring("does not exist");
  }

  public function redirectProvider(): dict<string, (string, string)> {
    return dict[
      'Hack class documentation' => tuple(
        '/manual/en/class.hack.maptktv.php',
        '/hack/reference/class/HH.Map/',
      ),
      'Hack class moved to HH namespace' =>
        tuple('/hack/reference/class/Map/', '/hack/reference/class/HH.Map/'),
      'Method in Hack class moved to HH namespace' => tuple(
        '/hack/reference/class/Map/filter/',
        '/hack/reference/class/HH.Map/filter/',
      ),
      'Hack interface reference with added namespace' => tuple(
        '/manual/en/class.hack.iterabletv.php',
        '/hack/reference/interface/HH.Iterable/',
      ),
      'Hack function reference' =>
        tuple('/manual/en/hackfuncref.php', '/hack/reference/'),
      'Hack function reference with preserved namespace' => tuple(
        '/manual/en/hack.asio.function.v.php',
        '/hack/reference/function/HH.Asio.v/',
      ),
      'Guide dir => first page of guide' => tuple(
        '/hack/getting-started/',
        '/hack/getting-started/getting-started',
      ),
      'Beta redirect root' =>
        tuple('http://beta.docs.hhvm.com/', 'https://docs.hhvm-cn.com/'),
      'Beta redirect page' => tuple(
        'http://beta.docs.hhvm.com/hack/reference/',
        'https://docs.hhvm-cn.com/hack/reference/',
      ),
      'Old Hack collection class overview' => tuple(
        '/manual/en/hack.collections.vector.php',
        '/hack/reference/class/Vector/',
      ),
      'Missing trailing /' =>
        tuple('/hack/reference/class/HH.Map', '/hack/reference/class/HH.Map/'),
      'Case insensitive redirect' =>
        tuple('/manual/en/HaCk.LAMbda.php', '/hack/lambdas/introduction'),
      'HSL function with Hack product' => tuple(
        '/hack/reference/function/HH.Lib.Str.length/',
        '/hsl/reference/function/HH.Lib.Str.length/',
      ),
    ];
  }

  <<DataProvider('redirectProvider'), TestGroup('remote')>>
  public async function testRedirects(
    string $from,
    string $to,
  ): Awaitable<void> {
    list($response, $_body) = await PageLoader::getPageAsync($from);
    expect($response->getStatusCode())->toBeSame(301);

    $target = $response->getHeaderLine('Location');
    expect($target)->toNotBeEmpty('no location header');

    expect($target)->toBeSame($to);
  }

  <<TestGroup('remote')>>
  public async function testStaticResource404(): Awaitable<void> {
    list($response, $_body) = await PageLoader::getPageAsync(
      '/s/deadbeef/notfound',
    );
    expect($response->getStatusCode())->toBeSame(404);
  }

  <<TestGroup('remote')>>
  public function notFoundSuggestions(): vec<(string, string)> {
    return vec[
      tuple('/map', '/hack/reference/class/HH.Map/'),
      tuple('/maptktv.filter', '/hack/reference/class/HH.Map/filter/'),
    ];
  }

  <<DataProvider('notFoundSuggestions'), TestGroup('remote')>>
  public async function testNotFoundSuggestion(
    string $notfound,
    string $suggestion,
  ): Awaitable<void> {
    list($response, $body) = await PageLoader::getPageAsync($notfound);
    expect($response->getStatusCode())->toBeSame(404);
    expect($body)->toContainSubstring($suggestion);
  }
}
