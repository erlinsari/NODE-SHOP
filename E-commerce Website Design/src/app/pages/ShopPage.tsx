import { useState, useRef } from 'react';
import { motion, useMotionValue, useSpring, useTransform } from 'motion/react';
import { Search, Filter, SlidersHorizontal } from 'lucide-react';
import { Button } from '../components/Button';
import { Card, CardBody } from '../components/Card';
import { Badge } from '../components/Badge';
import { products, categories, formatPrice, Product } from '../data/products';

interface ShopPageProps {
  onNavigate?: (page: string, productId?: string) => void;
  onAddToCart?: (product: Product) => void;
}

export function ShopPage({ onNavigate, onAddToCart }: ShopPageProps) {
  const [selectedCategory, setSelectedCategory] = useState('All');
  const [searchQuery, setSearchQuery] = useState('');
  const [priceRange, setPriceRange] = useState<[number, number]>([0, 300000]);
  const [showFilters, setShowFilters] = useState(false);

  const filteredProducts = products.filter((product) => {
    const matchesCategory =
      selectedCategory === 'All' || product.category === selectedCategory;
    const matchesSearch =
      searchQuery === '' ||
      product.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
      product.category.toLowerCase().includes(searchQuery.toLowerCase());
    const matchesPrice = product.price >= priceRange[0] && product.price <= priceRange[1];

    return matchesCategory && matchesSearch && matchesPrice;
  });

  return (
    <div className="min-h-screen py-8">
      <div className="container mx-auto px-4 lg:px-8">
        <div className="mb-8">
          <motion.h1
            className="font-black text-5xl md:text-7xl mb-4 uppercase"
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
          >
            PRODUCT <span className="text-[#FF0000]">CATALOG</span>
          </motion.h1>
          <p className="text-muted-foreground font-mono">
            {filteredProducts.length} products available
          </p>
        </div>

        <div className="flex gap-8">
          <motion.aside
            className={`${
              showFilters ? 'block' : 'hidden'
            } lg:block fixed lg:sticky top-24 left-0 z-40 w-64 bg-background border border-border rounded-[2px] p-6 h-fit max-h-[calc(100vh-8rem)] overflow-y-auto`}
            initial={{ opacity: 0, x: -20 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.5 }}
          >
            <div className="flex items-center justify-between mb-6">
              <h3 className="font-black uppercase">Filters</h3>
              <SlidersHorizontal className="w-4 h-4" />
            </div>

            <div className="space-y-6">
              <div>
                <label className="block font-mono text-sm mb-3 uppercase tracking-wider">
                  Search
                </label>
                <div className="relative">
                  <Search className="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground" />
                  <input
                    type="text"
                    placeholder="Search products..."
                    value={searchQuery}
                    onChange={(e) => setSearchQuery(e.target.value)}
                    className="w-full pl-10 pr-4 py-2 bg-input border border-border rounded-[2px] focus:outline-none focus:border-[#FF0000] transition-colors font-mono text-sm"
                  />
                </div>
              </div>

              <div>
                <label className="block font-mono text-sm mb-3 uppercase tracking-wider">
                  Category
                </label>
                <div className="space-y-2">
                  {categories.map((category) => (
                    <button
                      key={category}
                      onClick={() => setSelectedCategory(category)}
                      className={`w-full text-left px-3 py-2 rounded-[2px] transition-all duration-200 font-mono text-sm ${
                        selectedCategory === category
                          ? 'bg-[#FF0000] text-white'
                          : 'hover:bg-muted'
                      }`}
                    >
                      {category}
                    </button>
                  ))}
                </div>
              </div>

              <div>
                <label className="block font-mono text-sm mb-3 uppercase tracking-wider">
                  Price Range
                </label>
                <div className="space-y-3">
                  <div className="flex gap-2 items-center font-mono text-xs">
                    <span>{formatPrice(priceRange[0])}</span>
                    <span>-</span>
                    <span>{formatPrice(priceRange[1])}</span>
                  </div>
                  <input
                    type="range"
                    min="0"
                    max="300000"
                    step="10000"
                    value={priceRange[1]}
                    onChange={(e) => setPriceRange([0, parseInt(e.target.value)])}
                    className="w-full accent-[#FF0000]"
                  />
                </div>
              </div>

              <Button
                variant="outline"
                size="sm"
                onClick={() => {
                  setSelectedCategory('All');
                  setSearchQuery('');
                  setPriceRange([0, 300000]);
                }}
                className="w-full"
              >
                Reset Filters
              </Button>
            </div>
          </motion.aside>

          <div className="flex-1">
            <div className="mb-6 flex items-center gap-4 lg:hidden">
              <Button
                variant="outline"
                size="sm"
                onClick={() => setShowFilters(!showFilters)}
              >
                <Filter className="w-4 h-4 mr-2" />
                Filters
              </Button>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              {filteredProducts.map((product, index) => (
                <ProductCard
                  key={product.id}
                  product={product}
                  index={index}
                  onNavigate={onNavigate}
                  onAddToCart={onAddToCart}
                />
              ))}
            </div>

            {filteredProducts.length === 0 && (
              <div className="text-center py-20">
                <p className="text-muted-foreground font-mono text-lg mb-4">
                  No products found matching your filters
                </p>
                <Button
                  onClick={() => {
                    setSelectedCategory('All');
                    setSearchQuery('');
                    setPriceRange([0, 300000]);
                  }}
                >
                  Reset Filters
                </Button>
              </div>
            )}
          </div>
        </div>
      </div>
    </div>
  );
}

interface ProductCardProps {
  product: Product;
  index: number;
  onNavigate?: (page: string, productId?: string) => void;
  onAddToCart?: (product: Product) => void;
}

function ProductCard({ product, index, onNavigate, onAddToCart }: ProductCardProps) {
  const cardRef = useRef<HTMLDivElement>(null);
  const mouseX = useMotionValue(0);
  const mouseY = useMotionValue(0);

  const rotateX = useSpring(useTransform(mouseY, [-0.5, 0.5], [5, -5]), {
    stiffness: 300,
    damping: 20,
  });
  const rotateY = useSpring(useTransform(mouseX, [-0.5, 0.5], [-5, 5]), {
    stiffness: 300,
    damping: 20,
  });

  function handleMouseMove(e: React.MouseEvent<HTMLDivElement>) {
    if (!cardRef.current) return;

    const rect = cardRef.current.getBoundingClientRect();
    const centerX = rect.left + rect.width / 2;
    const centerY = rect.top + rect.height / 2;

    mouseX.set((e.clientX - centerX) / rect.width);
    mouseY.set((e.clientY - centerY) / rect.height);
  }

  function handleMouseLeave() {
    mouseX.set(0);
    mouseY.set(0);
  }

  return (
    <motion.div
      ref={cardRef}
      initial={{ opacity: 0, y: 40 }}
      animate={{ opacity: 1, y: 0 }}
      transition={{ duration: 0.5, delay: index * 0.05 }}
      style={{
        rotateX,
        rotateY,
        transformStyle: 'preserve-3d',
      }}
      onMouseMove={handleMouseMove}
      onMouseLeave={handleMouseLeave}
      className="group"
    >
      <Card hover className="overflow-hidden h-full flex flex-col cursor-pointer">
        <div
          className="relative h-56 overflow-hidden"
          onClick={() => onNavigate?.('product', product.id)}
        >
          <motion.img
            src={product.image}
            alt={product.name}
            className="w-full h-full object-cover"
            whileHover={{ scale: 1.1 }}
            transition={{ duration: 0.6 }}
          />
          <div className="absolute top-3 right-3">
            <Badge variant={product.stock > 50 ? 'success' : 'warning'}>
              {product.stock > 0 ? `Stock: ${product.stock}` : 'Out of Stock'}
            </Badge>
          </div>
        </div>

        <CardBody className="flex-1 flex flex-col">
          <Badge variant="outline" className="mb-3 w-fit">
            {product.category}
          </Badge>

          <h3
            className="font-black text-lg mb-2 group-hover:text-[#FF0000] transition-colors cursor-pointer"
            onClick={() => onNavigate?.('product', product.id)}
          >
            {product.name}
          </h3>

          <p className="text-sm text-muted-foreground font-mono mb-4 line-clamp-2 flex-1">
            {product.description}
          </p>

          <div className="flex items-end justify-between mt-auto">
            <div>
              <p className="text-xs text-muted-foreground font-mono mb-1">Price</p>
              <p className="font-black text-2xl">{formatPrice(product.price)}</p>
            </div>

            <Button
              size="sm"
              onClick={() => onAddToCart?.(product)}
              disabled={product.stock === 0}
            >
              Add to Cart
            </Button>
          </div>
        </CardBody>
      </Card>
    </motion.div>
  );
}
