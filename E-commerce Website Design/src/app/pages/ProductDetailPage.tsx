import { useState } from 'react';
import { motion } from 'motion/react';
import { ChevronLeft, Plus, Minus, ShoppingCart, Package, Shield, Zap } from 'lucide-react';
import { Button } from '../components/Button';
import { Card, CardBody, CardHeader } from '../components/Card';
import { Badge } from '../components/Badge';
import { products, formatPrice, Product } from '../data/products';

interface ProductDetailPageProps {
  productId?: string;
  onNavigate?: (page: string) => void;
  onAddToCart?: (product: Product, quantity: number) => void;
}

export function ProductDetailPage({
  productId,
  onNavigate,
  onAddToCart,
}: ProductDetailPageProps) {
  const product = products.find((p) => p.id === productId);
  const [quantity, setQuantity] = useState(1);
  const [imageZoom, setImageZoom] = useState(false);

  if (!product) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <h2 className="font-black text-3xl mb-4">Product Not Found</h2>
          <Button onClick={() => onNavigate?.('shop')}>Back to Shop</Button>
        </div>
      </div>
    );
  }

  const handleQuantityChange = (delta: number) => {
    const newQuantity = Math.max(1, Math.min(product.stock, quantity + delta));
    setQuantity(newQuantity);
  };

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
          Back to Shop
        </motion.button>

        <div className="grid lg:grid-cols-2 gap-12">
          <motion.div
            className="lg:sticky lg:top-24 h-fit"
            initial={{ opacity: 0, x: -40 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.6 }}
          >
            <Card className="overflow-hidden">
              <motion.div
                className="relative aspect-square bg-muted cursor-zoom-in"
                onClick={() => setImageZoom(!imageZoom)}
                whileHover={{ scale: imageZoom ? 1 : 1.02 }}
                transition={{ duration: 0.3 }}
              >
                <img
                  src={product.image}
                  alt={product.name}
                  className="w-full h-full object-cover"
                />
                <div className="absolute top-4 right-4">
                  <Badge variant={product.stock > 50 ? 'success' : 'warning'}>
                    {product.stock > 0 ? `Stock: ${product.stock}` : 'Out of Stock'}
                  </Badge>
                </div>
              </motion.div>
            </Card>

            <div className="grid grid-cols-3 gap-4 mt-4">
              <Card className="p-4 flex items-center gap-3">
                <Package className="w-5 h-5 text-[#FF0000]" />
                <div>
                  <p className="font-mono text-xs text-muted-foreground">Free Shipping</p>
                  <p className="font-black text-xs">Orders &gt; 500K</p>
                </div>
              </Card>
              <Card className="p-4 flex items-center gap-3">
                <Shield className="w-5 h-5 text-[#FF0000]" />
                <div>
                  <p className="font-mono text-xs text-muted-foreground">Warranty</p>
                  <p className="font-black text-xs">12 Months</p>
                </div>
              </Card>
              <Card className="p-4 flex items-center gap-3">
                <Zap className="w-5 h-5 text-[#FF0000]" />
                <div>
                  <p className="font-mono text-xs text-muted-foreground">Delivery</p>
                  <p className="font-black text-xs">1-3 Days</p>
                </div>
              </Card>
            </div>
          </motion.div>

          <motion.div
            initial={{ opacity: 0, x: 40 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.6 }}
          >
            <Badge variant="outline" className="mb-4">
              {product.category}
            </Badge>

            <h1 className="font-black text-4xl md:text-6xl mb-4 uppercase">
              {product.name}
            </h1>

            <div className="flex items-baseline gap-4 mb-6">
              <p className="font-black text-5xl">{formatPrice(product.price)}</p>
              <p className="text-muted-foreground font-mono line-through">
                {formatPrice(product.price * 1.2)}
              </p>
            </div>

            <p className="text-lg text-muted-foreground font-mono mb-8">
              {product.description}
            </p>

            <Card className="mb-8">
              <CardHeader>
                <h3 className="font-black uppercase">Technical Specifications</h3>
              </CardHeader>
              <CardBody>
                <div className="space-y-3">
                  {Object.entries(product.specs).map(([key, value]) => (
                    <div
                      key={key}
                      className="flex justify-between items-start py-2 border-b border-border last:border-0"
                    >
                      <span className="font-mono text-sm text-muted-foreground uppercase tracking-wider">
                        {key}
                      </span>
                      <span className="font-mono text-sm font-medium text-right max-w-[60%]">
                        {value}
                      </span>
                    </div>
                  ))}
                </div>
              </CardBody>
            </Card>

            <Card className="mb-8">
              <CardHeader>
                <h3 className="font-black uppercase">Key Features</h3>
              </CardHeader>
              <CardBody>
                <ul className="space-y-3">
                  {product.features.map((feature, index) => (
                    <motion.li
                      key={index}
                      className="flex items-start gap-3"
                      initial={{ opacity: 0, x: -20 }}
                      animate={{ opacity: 1, x: 0 }}
                      transition={{ duration: 0.3, delay: index * 0.1 }}
                    >
                      <div className="w-1.5 h-1.5 bg-[#FF0000] rounded-full mt-2 flex-shrink-0" />
                      <span className="font-mono text-sm">{feature}</span>
                    </motion.li>
                  ))}
                </ul>
              </CardBody>
            </Card>

            <Card className="mb-8">
              <CardBody>
                <div className="flex items-center justify-between mb-6">
                  <div>
                    <p className="font-mono text-sm text-muted-foreground mb-2">Quantity</p>
                    <div className="flex items-center gap-4">
                      <button
                        onClick={() => handleQuantityChange(-1)}
                        className="w-10 h-10 border-2 border-border rounded-[2px] hover:border-[#FF0000] transition-colors flex items-center justify-center"
                        disabled={quantity <= 1}
                      >
                        <Minus className="w-4 h-4" />
                      </button>
                      <span className="font-black text-2xl w-12 text-center">{quantity}</span>
                      <button
                        onClick={() => handleQuantityChange(1)}
                        className="w-10 h-10 border-2 border-border rounded-[2px] hover:border-[#FF0000] transition-colors flex items-center justify-center"
                        disabled={quantity >= product.stock}
                      >
                        <Plus className="w-4 h-4" />
                      </button>
                    </div>
                  </div>

                  <div className="text-right">
                    <p className="font-mono text-sm text-muted-foreground mb-2">Subtotal</p>
                    <p className="font-black text-3xl">
                      {formatPrice(product.price * quantity)}
                    </p>
                  </div>
                </div>

                <div className="flex gap-4">
                  <Button
                    size="lg"
                    className="flex-1"
                    onClick={() => onAddToCart?.(product, quantity)}
                    disabled={product.stock === 0}
                  >
                    <ShoppingCart className="mr-2 w-5 h-5" />
                    Add to Cart
                  </Button>
                  <Button size="lg" variant="outline" className="flex-1">
                    Buy Now
                  </Button>
                </div>
              </CardBody>
            </Card>
          </motion.div>
        </div>
      </div>
    </div>
  );
}
