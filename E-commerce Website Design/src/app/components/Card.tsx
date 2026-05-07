import { HTMLAttributes, ReactNode } from 'react';
import { cn } from '../../lib/utils';

interface CardProps extends HTMLAttributes<HTMLDivElement> {
  children: ReactNode;
  hover?: boolean;
}

export const Card = ({ className, children, hover = false, ...props }: CardProps) => {
  return (
    <div
      className={cn(
        'bg-card text-card-foreground border border-border rounded-[2px]',
        'transition-all duration-300',
        hover && 'hover:border-[#FF0000] hover:shadow-lg hover:shadow-[#FF0000]/10',
        className
      )}
      {...props}
    >
      {children}
    </div>
  );
};

export const CardHeader = ({ className, children, ...props }: HTMLAttributes<HTMLDivElement>) => {
  return (
    <div className={cn('p-6 border-b border-border', className)} {...props}>
      {children}
    </div>
  );
};

export const CardBody = ({ className, children, ...props }: HTMLAttributes<HTMLDivElement>) => {
  return (
    <div className={cn('p-6', className)} {...props}>
      {children}
    </div>
  );
};

export const CardFooter = ({ className, children, ...props }: HTMLAttributes<HTMLDivElement>) => {
  return (
    <div className={cn('p-6 border-t border-border', className)} {...props}>
      {children}
    </div>
  );
};
