import { motion, useScroll, useTransform } from 'motion/react';
import { Button } from '../components/Button';
import { Card, CardBody } from '../components/Card';
import { Badge } from '../components/Badge';
import { Cpu, Zap, Shield, TrendingUp, ChevronRight } from 'lucide-react';
import { useRef } from 'react';

interface HomePageProps {
  onNavigate?: (page: string, productId?: string) => void;
}

export function HomePage({ onNavigate }: HomePageProps) {
  const heroRef = useRef<HTMLDivElement>(null);
  const { scrollYProgress } = useScroll({
    target: heroRef,
    offset: ['start start', 'end start'],
  });

  const heroY = useTransform(scrollYProgress, [0, 1], ['0%', '50%']);
  const heroOpacity = useTransform(scrollYProgress, [0, 0.5], [1, 0]);
  const heroScale = useTransform(scrollYProgress, [0, 1], [1, 1.2]);

  const categories = [
    {
      title: 'MICROCONTROLLERS',
      subtitle: 'ESP32 • Arduino • RP2040',
      image: 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=600&q=80',
      products: 127,
    },
    {
      title: 'SENSORS',
      subtitle: 'Environmental • Motion • Distance',
      image: 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80',
      products: 284,
    },
    {
      title: 'DISPLAYS',
      subtitle: 'OLED • LCD • E-Paper',
      image: 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?w=600&q=80',
      products: 95,
    },
    {
      title: 'COMMUNICATION',
      subtitle: 'WiFi • Bluetooth • LoRa',
      image: 'https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?w=600&q=80',
      products: 68,
    },
  ];

  const features = [
    {
      icon: Cpu,
      title: 'Professional Grade',
      description: 'Industrial-quality components for production-ready applications',
    },
    {
      icon: Zap,
      title: 'High Performance',
      description: 'Optimized for speed, efficiency, and reliability',
    },
    {
      icon: Shield,
      title: 'Guaranteed Quality',
      description: 'Rigorous testing and quality control on every component',
    },
    {
      icon: TrendingUp,
      title: 'Latest Technology',
      description: 'Cutting-edge IoT hardware with the newest specifications',
    },
  ];

  const titleWords = ['PROFESSIONAL', 'IoT', 'HARDWARE'];

  return (
    <div className="min-h-screen">
      <section ref={heroRef} className="relative h-[90vh] overflow-hidden flex items-center">
        <motion.div
          className="absolute inset-0 z-0"
          style={{ y: heroY, scale: heroScale }}
        >
          <div className="absolute inset-0 bg-gradient-to-br from-background via-background to-[#FF0000]/5" />
          <div className="absolute top-0 right-0 w-1/2 h-full opacity-10">
            <div className="absolute top-20 right-20 w-96 h-96 border border-foreground/20 rounded-[2px] rotate-12" />
            <div className="absolute top-40 right-40 w-64 h-64 border border-foreground/20 rounded-[2px] -rotate-6" />
            <div className="absolute bottom-20 right-10 w-80 h-80 border-2 border-[#FF0000]/30 rounded-[2px]" />
          </div>
        </motion.div>

        <motion.div
          className="container mx-auto px-4 lg:px-8 relative z-10"
          style={{ opacity: heroOpacity }}
        >
          <div className="max-w-4xl">
            <motion.div
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              transition={{ duration: 0.5 }}
            >
              <Badge variant="outline" className="mb-6">
                INDUSTRIAL IoT SOLUTIONS
              </Badge>
            </motion.div>

            <div className="mb-8 overflow-hidden">
              {titleWords.map((word, wordIndex) => (
                <div key={wordIndex} className="overflow-hidden">
                  <motion.h1
                    className="font-black text-6xl md:text-8xl lg:text-9xl leading-none mb-2"
                    initial={{ y: 100, opacity: 0 }}
                    animate={{ y: 0, opacity: 1 }}
                    transition={{
                      duration: 0.8,
                      delay: wordIndex * 0.15,
                      ease: [0.22, 1, 0.36, 1],
                    }}
                  >
                    {word === 'IoT' ? (
                      <span className="text-[#FF0000]">{word}</span>
                    ) : (
                      word
                    )}
                  </motion.h1>
                </div>
              ))}
            </div>

            <motion.p
              className="text-xl md:text-2xl text-muted-foreground max-w-2xl mb-8 font-mono"
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.8, delay: 0.6 }}
            >
              Premium microcontrollers, sensors, and development boards for professionals
            </motion.p>

            <motion.div
              className="flex flex-wrap gap-4"
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.8, delay: 0.8 }}
            >
              <Button size="lg" onClick={() => onNavigate?.('shop')}>
                Browse Catalog
                <ChevronRight className="ml-2 w-5 h-5" />
              </Button>
              <Button variant="outline" size="lg">
                View Specs
              </Button>
            </motion.div>
          </div>
        </motion.div>
      </section>

      <section className="py-24 border-t border-border">
        <div className="container mx-auto px-4 lg:px-8">
          <motion.div
            initial={{ opacity: 0, y: 40 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true, margin: '-100px' }}
            transition={{ duration: 0.8 }}
            className="text-center mb-16"
          >
            <h2 className="font-black text-4xl md:text-6xl mb-4 uppercase">
              PRODUCT <span className="text-[#FF0000]">CATEGORIES</span>
            </h2>
            <p className="text-muted-foreground font-mono">
              Explore our curated selection of premium IoT components
            </p>
          </motion.div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {categories.map((category, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, y: 40 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true, margin: '-50px' }}
                transition={{ duration: 0.6, delay: index * 0.1 }}
              >
                <Card
                  hover
                  className="overflow-hidden group cursor-pointer h-full"
                  onClick={() => onNavigate?.('shop')}
                >
                  <div className="relative h-48 overflow-hidden">
                    <motion.img
                      src={category.image}
                      alt={category.title}
                      className="w-full h-full object-cover"
                      whileHover={{ scale: 1.1 }}
                      transition={{ duration: 0.6 }}
                    />
                    <div className="absolute inset-0 bg-gradient-to-t from-background/90 to-transparent" />
                    <div className="absolute bottom-4 left-4 right-4">
                      <h3 className="font-black text-xl mb-1">{category.title}</h3>
                      <p className="text-sm text-muted-foreground font-mono">
                        {category.subtitle}
                      </p>
                    </div>
                  </div>
                  <CardBody className="flex justify-between items-center">
                    <span className="font-mono text-sm text-muted-foreground">
                      {category.products} products
                    </span>
                    <ChevronRight className="w-5 h-5 group-hover:translate-x-1 transition-transform" />
                  </CardBody>
                </Card>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      <section className="py-24 border-t border-border bg-muted/30">
        <div className="container mx-auto px-4 lg:px-8">
          <motion.div
            initial={{ opacity: 0, y: 40 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true, margin: '-100px' }}
            transition={{ duration: 0.8 }}
            className="text-center mb-16"
          >
            <h2 className="font-black text-4xl md:text-6xl mb-4 uppercase">
              WHY CHOOSE <span className="text-[#FF0000]">NODE SHOP</span>
            </h2>
          </motion.div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {features.map((feature, index) => (
              <motion.div
                key={index}
                initial={{ opacity: 0, y: 40 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true, margin: '-50px' }}
                transition={{ duration: 0.6, delay: index * 0.1 }}
                className="text-center"
              >
                <div className="inline-flex p-4 rounded-[2px] border-2 border-border mb-6 group hover:border-[#FF0000] transition-colors duration-300">
                  <feature.icon className="w-8 h-8 group-hover:text-[#FF0000] transition-colors" />
                </div>
                <h3 className="font-black text-xl mb-3 uppercase">{feature.title}</h3>
                <p className="text-muted-foreground font-mono text-sm">
                  {feature.description}
                </p>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      <section className="py-24 border-t border-border">
        <div className="container mx-auto px-4 lg:px-8">
          <Card className="overflow-hidden">
            <div className="grid md:grid-cols-2">
              <div className="p-12 flex flex-col justify-center">
                <motion.div
                  initial={{ opacity: 0, x: -40 }}
                  whileInView={{ opacity: 1, x: 0 }}
                  viewport={{ once: true }}
                  transition={{ duration: 0.8 }}
                >
                  <Badge variant="primary" className="mb-6">
                    FEATURED
                  </Badge>
                  <h2 className="font-black text-4xl md:text-5xl mb-4 uppercase">
                    ESP32-S3 <br />
                    <span className="text-[#FF0000]">AI ACCELERATED</span>
                  </h2>
                  <p className="text-muted-foreground font-mono mb-8">
                    High-performance module dengan vector instructions untuk machine learning
                    dan computer vision applications.
                  </p>
                  <div className="space-y-3 mb-8">
                    <div className="flex items-center gap-3">
                      <div className="w-1 h-1 bg-[#FF0000] rounded-full" />
                      <span className="font-mono text-sm">Dual-core Xtensa LX7 @ 240MHz</span>
                    </div>
                    <div className="flex items-center gap-3">
                      <div className="w-1 h-1 bg-[#FF0000] rounded-full" />
                      <span className="font-mono text-sm">8MB Flash + 8MB PSRAM</span>
                    </div>
                    <div className="flex items-center gap-3">
                      <div className="w-1 h-1 bg-[#FF0000] rounded-full" />
                      <span className="font-mono text-sm">WiFi 6 + Bluetooth 5.0</span>
                    </div>
                  </div>
                  <Button onClick={() => onNavigate?.('product', 'esp32-s3')}>
                    View Details
                    <ChevronRight className="ml-2 w-4 h-4" />
                  </Button>
                </motion.div>
              </div>
              <motion.div
                className="relative h-96 md:h-auto bg-gradient-to-br from-muted to-muted/50"
                initial={{ opacity: 0, scale: 0.9 }}
                whileInView={{ opacity: 1, scale: 1 }}
                viewport={{ once: true }}
                transition={{ duration: 0.8 }}
              >
                <img
                  src="https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?w=800&q=80"
                  alt="ESP32-S3"
                  className="w-full h-full object-cover"
                />
              </motion.div>
            </div>
          </Card>
        </div>
      </section>
    </div>
  );
}
