import { useState } from 'react';
import { ThemeProvider } from './components/ThemeProvider';
import { Header } from './components/Header';
import { HomePage } from './pages/HomePage';
import { ShopPage } from './pages/ShopPage';
import { ProductDetailPage } from './pages/ProductDetailPage';
import { CartPage, CartItem } from './pages/CartPage';
import { CheckoutPage } from './pages/CheckoutPage';
import { OrdersPage } from './pages/OrdersPage';
import { AdminPage } from './pages/AdminPage';
import { Product } from './data/products';
import { toast } from 'sonner';
import { Toaster } from './components/ui/sonner';

type Page = 'home' | 'shop' | 'product' | 'cart' | 'checkout' | 'orders' | 'admin';

export default function App() {
  const [currentPage, setCurrentPage] = useState<Page>('home');
  const [selectedProductId, setSelectedProductId] = useState<string | undefined>();
  const [cartItems, setCartItems] = useState<CartItem[]>([]);

  const handleNavigate = (page: string, productId?: string) => {
    setCurrentPage(page as Page);
    setSelectedProductId(productId);
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  const handleAddToCart = (product: Product, quantity: number = 1) => {
    setCartItems((prevItems) => {
      const existingItem = prevItems.find((item) => item.product.id === product.id);

      if (existingItem) {
        toast.success(`Updated ${product.name} quantity in cart`);
        return prevItems.map((item) =>
          item.product.id === product.id
            ? { ...item, quantity: Math.min(item.quantity + quantity, product.stock) }
            : item
        );
      }

      toast.success(`Added ${product.name} to cart`);
      return [...prevItems, { product, quantity }];
    });
  };

  const handleUpdateQuantity = (productId: string, delta: number) => {
    setCartItems((prevItems) =>
      prevItems
        .map((item) => {
          if (item.product.id === productId) {
            const newQuantity = Math.max(
              1,
              Math.min(item.quantity + delta, item.product.stock)
            );
            return { ...item, quantity: newQuantity };
          }
          return item;
        })
        .filter((item) => item.quantity > 0)
    );
  };

  const handleRemoveItem = (productId: string) => {
    setCartItems((prevItems) => prevItems.filter((item) => item.product.id !== productId));
    toast.success('Item removed from cart');
  };

  const handleCheckout = () => {
    handleNavigate('checkout');
  };

  const handlePlaceOrder = (orderData: any) => {
    console.log('Order placed:', orderData);
    setCartItems([]);
    toast.success('Order placed successfully!');
  };

  const cartItemCount = cartItems.reduce((sum, item) => sum + item.quantity, 0);

  return (
    <ThemeProvider>
      <div className="min-h-screen bg-background text-foreground">
        <Toaster position="bottom-right" />

        <Header cartItemCount={cartItemCount} onNavigate={handleNavigate} />

        <main>
          {currentPage === 'home' && <HomePage onNavigate={handleNavigate} />}

          {currentPage === 'shop' && (
            <ShopPage onNavigate={handleNavigate} onAddToCart={handleAddToCart} />
          )}

          {currentPage === 'product' && (
            <ProductDetailPage
              productId={selectedProductId}
              onNavigate={handleNavigate}
              onAddToCart={handleAddToCart}
            />
          )}

          {currentPage === 'cart' && (
            <CartPage
              cartItems={cartItems}
              onUpdateQuantity={handleUpdateQuantity}
              onRemoveItem={handleRemoveItem}
              onNavigate={handleNavigate}
              onCheckout={handleCheckout}
            />
          )}

          {currentPage === 'checkout' && (
            <CheckoutPage
              cartItems={cartItems}
              onNavigate={handleNavigate}
              onPlaceOrder={handlePlaceOrder}
            />
          )}

          {currentPage === 'orders' && <OrdersPage />}

          {currentPage === 'admin' && <AdminPage />}
        </main>

        <footer className="border-t border-border mt-20">
          <div className="container mx-auto px-4 lg:px-8 py-12">
            <div className="grid md:grid-cols-4 gap-8">
              <div>
                <div className="flex items-center gap-2 mb-4">
                  <div className="w-8 h-8 bg-[#FF0000] rounded-[2px] flex items-center justify-center">
                    <span className="text-white font-black text-lg">N</span>
                  </div>
                  <span className="font-black text-xl tracking-tighter uppercase">
                    NODE<span className="text-[#FF0000]">SHOP</span>
                  </span>
                </div>
                <p className="text-sm font-mono text-muted-foreground">
                  Professional IoT hardware for developers and engineers.
                </p>
              </div>

              <div>
                <h3 className="font-black uppercase mb-4">Shop</h3>
                <ul className="space-y-2 font-mono text-sm">
                  <li>
                    <button
                      onClick={() => handleNavigate('shop')}
                      className="text-muted-foreground hover:text-[#FF0000] transition-colors"
                    >
                      All Products
                    </button>
                  </li>
                  <li className="text-muted-foreground">Microcontrollers</li>
                  <li className="text-muted-foreground">Sensors</li>
                  <li className="text-muted-foreground">Displays</li>
                </ul>
              </div>

              <div>
                <h3 className="font-black uppercase mb-4">Support</h3>
                <ul className="space-y-2 font-mono text-sm">
                  <li className="text-muted-foreground">Documentation</li>
                  <li className="text-muted-foreground">Contact</li>
                  <li className="text-muted-foreground">Warranty</li>
                  <li className="text-muted-foreground">Shipping</li>
                </ul>
              </div>

              <div>
                <h3 className="font-black uppercase mb-4">Connect</h3>
                <ul className="space-y-2 font-mono text-sm">
                  <li className="text-muted-foreground">GitHub</li>
                  <li className="text-muted-foreground">Twitter</li>
                  <li className="text-muted-foreground">Discord</li>
                  <li className="text-muted-foreground">YouTube</li>
                </ul>
              </div>
            </div>

            <div className="mt-12 pt-8 border-t border-border">
              <p className="text-center font-mono text-sm text-muted-foreground">
                &copy; 2026 NODE SHOP. All rights reserved. Built with precision.
              </p>
            </div>
          </div>
        </footer>
      </div>
    </ThemeProvider>
  );
}
