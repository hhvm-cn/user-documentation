<?hh // strict

namespace Hack\UserDocumentation\Types\Void\Examples\DrawLine;

function draw_line(Point $p1, Point $p2): void { /* ... */ }

class Point {
  private float $x;
  private float $y;
  public function __construct(num $x = 0, num $y = 0) {
    $this->x = (float)$x;
    $this->y = (float)$y;
  }
  public function move(num $x = 0, num $y = 0): void {
    $this->x = (float)$x;
    $this->y = (float)$y;
  }
  // ...
}

<<__EntryPoint>>
function main(): void {
  draw_line(new Point(1.2, 3.3), new Point(6.2, -4.5));
}
