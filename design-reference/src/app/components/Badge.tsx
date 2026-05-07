import { HTMLAttributes } from 'react';
import { cn } from '../../lib/utils';

interface BadgeProps extends HTMLAttributes<HTMLSpanElement> {
  variant?: 'primary' | 'secondary' | 'success' | 'warning' | 'danger' | 'outline';
}

export const Badge = ({ className, variant = 'secondary', children, ...props }: BadgeProps) => {
  return (
    <span
      className={cn(
        'inline-flex items-center px-2.5 py-0.5 rounded-[2px] text-xs font-mono uppercase tracking-wider',
        'border transition-colors duration-200',
        {
          'bg-[#FF0000] text-white border-[#FF0000]': variant === 'primary',
          'bg-secondary text-secondary-foreground border-secondary': variant === 'secondary',
          'bg-green-600 text-white border-green-600': variant === 'success',
          'bg-yellow-600 text-white border-yellow-600': variant === 'warning',
          'bg-[#FF0000] text-white border-[#FF0000]': variant === 'danger',
          'bg-transparent border-border text-foreground': variant === 'outline',
        },
        className
      )}
      {...props}
    >
      {children}
    </span>
  );
};
