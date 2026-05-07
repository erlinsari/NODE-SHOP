import { motion } from 'motion/react';
import { Trash2, Plus, Minus, ShoppingBag, ChevronLeft } from 'lucide-react';
import { Button } from '../components/Button';
import { Card, CardBody, CardHeader, CardFooter } from '../components/Card';
import { Badge } from '../components/Badge';
import { formatPrice, Product } from '../data/products';

export interface CartItem {
  product: Product;
  quantity: number;
}

interface CartPageProps {
  cartItems: CartItem[];
  onUpdateQuantity: (productId: string, delta: number) => void;
  onRemoveItem: (productId: string) => void;
  onNavigate?: (page: string) => void;
  onCheckout?: () => void;
}

export function CartPage({
  cartItems,
  onUpdateQuantity,
  onRemoveItem,
  onNavigate,
  onCheckout,
}: CartPageProps) {
  const subtotal = cartItems.reduce(
    (sum, item) => sum + item.product.price * item.quantity,
    0
  );
  const shipping = subtotal > 500000 ? 0 : 25000;
  const tax = subtotal * 0.11;
  const total = subtotal + shipping + tax;

  if (cartItems.length === 0) {
    return (
      <div className="min-h-screen flex items-center justify-center py-8">
        <div className="text-center">
          <motion.div
            initial={{ scale: 0 }}
            animate={{ scale: 1 }}
            transition={{ duration: 0.5 }}
            className="inline-flex p-8 rounded-[2px] border-2 border-border mb-6"
          >
            <ShoppingBag className="w-16 h-16 text-muted-foreground" />
          </motion.div>
          <h2 className="font-black text-3xl mb-4 uppercase">Your Cart is Empty</h2>
          <p className="text-muted-foreground font-mono mb-8">
            Add some professional IoT hardware to get started
          </p>
          <Button onClick={() => onNavigate?.('shop')}>Browse Products</Button>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen py-8">
      <div className="container mx-auto px-4 lg:px-8">
        <motion.button
          onClick={() => onNavigate?.('shop')}
          className="flex items-center gap-2 mb-8 hover:text-[#FF0000] transition-colors font-mono uppercase text-sm"
          initial={{ opacity: 0, x: -20 }}
          animate={{ opacity: 1, x: 0 }}
        >
          <ChevronLeft className="w-4 h-4" />
          Continue Shopping
        </motion.button>

        <motion.h1
          className="font-black text-5xl md:text-7xl mb-8 uppercase"
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
        >
          Shopping <span className="text-[#FF0000]">Cart</span>
        </motion.h1>

        <div className="grid lg:grid-cols-3 gap-8">
          <div className="lg:col-span-2 space-y-4">
            {cartItems.map((item, index) => (
              <motion.div
                key={item.product.id}
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.4, delay: index * 0.1 }}
              >
                <Card>
                  <CardBody className="flex gap-6">
                    <img
                      src={item.product.image}
                      alt={item.product.name}
                      className="w-24 h-24 object-cover rounded-[2px]"
                    />

                    <div className="flex-1">
                      <div className="flex justify-between items-start mb-2">
                        <div>
                          <Badge variant="outline" className="mb-2">
                            {item.product.category}
                          </Badge>
                          <h3 className="font-black text-lg">{item.product.name}</h3>
                        </div>
                        <button
                          onClick={() => onRemoveItem(item.product.id)}
                          className="p-2 hover:bg-muted rounded-[2px] transition-colors text-muted-foreground hover:text-[#FF0000]"
                        >
                          <Trash2 className="w-4 h-4" />
                        </button>
                      </div>

                      <p className="text-sm text-muted-foreground font-mono mb-4 line-clamp-2">
                        {item.product.description}
                      </p>

                      <div className="flex justify-between items-center">
                        <div className="flex items-center gap-3">
                          <button
                            onClick={() => onUpdateQuantity(item.product.id, -1)}
                            className="w-8 h-8 border border-border rounded-[2px] hover:border-[#FF0000] transition-colors flex items-center justify-center"
                            disabled={item.quantity <= 1}
                          >
                            <Minus className="w-3 h-3" />
                          </button>
                          <span className="font-mono font-black w-8 text-center">
                            {item.quantity}
                          </span>
                          <button
                            onClick={() => onUpdateQuantity(item.product.id, 1)}
                            className="w-8 h-8 border border-border rounded-[2px] hover:border-[#FF0000] transition-colors flex items-center justify-center"
                            disabled={item.quantity >= item.product.stock}
                          >
                            <Plus className="w-3 h-3" />
                          </button>
                        </div>

                        <p className="font-black text-2xl">
                          {formatPrice(item.product.price * item.quantity)}
                        </p>
                      </div>
                    </div>
                  </CardBody>
                </Card>
              </motion.div>
            ))}
          </div>

          <motion.div
            className="lg:sticky lg:top-24 h-fit"
            initial={{ opacity: 0, x: 40 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.6 }}
          >
            <Card className="border-2">
              <CardHeader className="border-b-2 border-border">
                <h2 className="font-black uppercase text-xl">Order Summary</h2>
              </CardHeader>

              <CardBody className="space-y-4 font-mono">
                <div className="flex justify-between items-center py-2">
                  <span className="text-muted-foreground">Subtotal</span>
                  <span className="font-black">{formatPrice(subtotal)}</span>
                </div>

                <div className="flex justify-between items-center py-2">
                  <span className="text-muted-foreground">Shipping</span>
                  <span className="font-black">
                    {shipping === 0 ? (
                      <Badge variant="success">FREE</Badge>
                    ) : (
                      formatPrice(shipping)
                    )}
                  </span>
                </div>

                <div className="flex justify-between items-center py-2">
                  <span className="text-muted-foreground">Tax (11%)</span>
                  <span className="font-black">{formatPrice(tax)}</span>
                </div>

                {subtotal < 500000 && (
                  <div className="bg-muted/50 p-3 rounded-[2px] border border-border">
                    <p className="text-xs font-mono">
                      Add {formatPrice(500000 - subtotal)} more for free shipping
                    </p>
                  </div>
                )}

                <div className="h-px bg-border my-4" />

                <div className="flex justify-between items-center py-2">
                  <span className="text-lg font-black uppercase">Total</span>
                  <span className="text-3xl font-black">{formatPrice(total)}</span>
                </div>
              </CardBody>

              <CardFooter className="border-t-2 border-border">
                <Button size="lg" className="w-full" onClick={onCheckout}>
                  Proceed to Checkout
                </Button>
              </CardFooter>
            </Card>

            <div className="mt-6 space-y-3">
              <Card className="p-4 flex items-start gap-3 text-sm">
                <div className="w-1 h-1 bg-[#FF0000] rounded-full mt-2 flex-shrink-0" />
                <p className="font-mono text-muted-foreground">
                  Free shipping on orders over Rp 500.000
                </p>
              </Card>
              <Card className="p-4 flex items-start gap-3 text-sm">
                <div className="w-1 h-1 bg-[#FF0000] rounded-full mt-2 flex-shrink-0" />
                <p className="font-mono text-muted-foreground">
                  12-month warranty on all products
                </p>
              </Card>
              <Card className="p-4 flex items-start gap-3 text-sm">
                <div className="w-1 h-1 bg-[#FF0000] rounded-full mt-2 flex-shrink-0" />
                <p className="font-mono text-muted-foreground">
                  Secure payment processing
                </p>
              </Card>
            </div>
          </motion.div>
        </div>
      </div>
    </div>
  );
}
