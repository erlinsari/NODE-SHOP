import { ShoppingCart, User, Menu } from 'lucide-react';
import { ThemeToggle } from './ThemeToggle';
import { Badge } from './Badge';
import { useState } from 'react';

interface HeaderProps {
  cartItemCount?: number;
  onNavigate?: (page: string) => void;
}

export function Header({ cartItemCount = 0, onNavigate }: HeaderProps) {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  const navItems = [
    { label: 'Home', value: 'home' },
    { label: 'Shop', value: 'shop' },
    { label: 'Orders', value: 'orders' },
    { label: 'Admin', value: 'admin' },
  ];

  return (
    <header className="sticky top-0 z-50 w-full border-b border-border bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/80">
      <div className="container mx-auto px-4 lg:px-8">
        <div className="flex h-16 items-center justify-between">
          <div className="flex items-center gap-8">
            <button
              onClick={() => onNavigate?.('home')}
              className="flex items-center gap-2 hover:opacity-80 transition-opacity"
            >
              <div className="w-8 h-8 bg-[#FF0000] rounded-[2px] flex items-center justify-center">
                <span className="text-white font-black text-lg">N</span>
              </div>
              <span className="font-black text-xl tracking-tighter uppercase">
                NODE<span className="text-[#FF0000]">SHOP</span>
              </span>
            </button>

            <nav className="hidden md:flex items-center gap-6">
              {navItems.map((item) => (
                <button
                  key={item.value}
                  onClick={() => onNavigate?.(item.value)}
                  className="text-sm uppercase tracking-wider font-medium hover:text-[#FF0000] transition-colors duration-200 relative group"
                >
                  {item.label}
                  <span className="absolute bottom-0 left-0 w-0 h-[2px] bg-[#FF0000] group-hover:w-full transition-all duration-300" />
                </button>
              ))}
            </nav>
          </div>

          <div className="flex items-center gap-4">
            <ThemeToggle />

            <button
              onClick={() => onNavigate?.('cart')}
              className="relative p-2 rounded-[2px] border border-border hover:border-[#FF0000] transition-all duration-200"
            >
              <ShoppingCart className="w-5 h-5" />
              {cartItemCount > 0 && (
                <span className="absolute -top-1 -right-1 bg-[#FF0000] text-white text-xs font-mono w-5 h-5 rounded-full flex items-center justify-center">
                  {cartItemCount}
                </span>
              )}
            </button>

            <button className="p-2 rounded-[2px] border border-border hover:border-[#FF0000] transition-all duration-200">
              <User className="w-5 h-5" />
            </button>

            <button
              onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
              className="md:hidden p-2 rounded-[2px] border border-border hover:border-[#FF0000] transition-all duration-200"
            >
              <Menu className="w-5 h-5" />
            </button>
          </div>
        </div>

        {mobileMenuOpen && (
          <nav className="md:hidden py-4 border-t border-border">
            <div className="flex flex-col gap-4">
              {navItems.map((item) => (
                <button
                  key={item.value}
                  onClick={() => {
                    onNavigate?.(item.value);
                    setMobileMenuOpen(false);
                  }}
                  className="text-left text-sm uppercase tracking-wider font-medium hover:text-[#FF0000] transition-colors duration-200 py-2"
                >
                  {item.label}
                </button>
              ))}
            </div>
          </nav>
        )}
      </div>
    </header>
  );
}
