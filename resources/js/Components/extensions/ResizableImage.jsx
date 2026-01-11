import { Node, mergeAttributes } from '@tiptap/core';
import { ReactNodeViewRenderer, NodeViewWrapper } from '@tiptap/react';
import { useCallback, useEffect, useRef, useState } from 'react';

// React component for the resizable image
const ResizableImageComponent = ({ node, updateAttributes, selected }) => {
    const imageRef = useRef(null);
    const [isResizing, setIsResizing] = useState(false);
    const [startPos, setStartPos] = useState({ x: 0, y: 0 });
    const [startSize, setStartSize] = useState({ width: 0, height: 0 });

    const handleMouseDown = useCallback((e, corner) => {
        e.preventDefault();
        e.stopPropagation();

        if (!imageRef.current) return;

        const rect = imageRef.current.getBoundingClientRect();
        setIsResizing(corner);
        setStartPos({ x: e.clientX, y: e.clientY });
        setStartSize({ width: rect.width, height: rect.height });
    }, []);

    const handleMouseMove = useCallback((e) => {
        if (!isResizing) return;

        const deltaX = e.clientX - startPos.x;
        const deltaY = e.clientY - startPos.y;

        let newWidth = startSize.width;
        let newHeight = startSize.height;

        // Calculate new dimensions based on corner
        if (isResizing.includes('right')) {
            newWidth = Math.max(50, startSize.width + deltaX);
        } else if (isResizing.includes('left')) {
            newWidth = Math.max(50, startSize.width - deltaX);
        }

        if (isResizing.includes('bottom')) {
            newHeight = Math.max(50, startSize.height + deltaY);
        } else if (isResizing.includes('top')) {
            newHeight = Math.max(50, startSize.height - deltaY);
        }

        // Maintain aspect ratio if shift is held
        if (e.shiftKey) {
            const aspectRatio = startSize.width / startSize.height;
            if (deltaX > deltaY) {
                newHeight = newWidth / aspectRatio;
            } else {
                newWidth = newHeight * aspectRatio;
            }
        }

        updateAttributes({
            width: Math.round(newWidth),
            height: Math.round(newHeight),
        });
    }, [isResizing, startPos, startSize, updateAttributes]);

    const handleMouseUp = useCallback(() => {
        setIsResizing(false);
    }, []);

    useEffect(() => {
        if (isResizing) {
            document.addEventListener('mousemove', handleMouseMove);
            document.addEventListener('mouseup', handleMouseUp);
            return () => {
                document.removeEventListener('mousemove', handleMouseMove);
                document.removeEventListener('mouseup', handleMouseUp);
            };
        }
    }, [isResizing, handleMouseMove, handleMouseUp]);

    const { src, alt, title, width, height, style } = node.attrs;

    return (
        <NodeViewWrapper
            className={`image-resizer ${selected ? 'selected' : ''}`}
            style={{
                display: 'inline-block',
                position: 'relative',
                ...(style ? { cssText: style } : {}),
            }}
        >
            <img
                ref={imageRef}
                src={src}
                alt={alt || ''}
                title={title || ''}
                style={{
                    width: width ? `${width}px` : 'auto',
                    height: height ? `${height}px` : 'auto',
                    display: 'block',
                    maxWidth: '100%',
                }}
                draggable={false}
            />

            {selected && (
                <>
                    {/* Corner resize handles */}
                    <div
                        className="resize-handle top-left"
                        onMouseDown={(e) => handleMouseDown(e, 'top-left')}
                        style={{
                            position: 'absolute',
                            top: -6,
                            left: -6,
                            width: 12,
                            height: 12,
                            background: '#d40c19',
                            border: '2px solid white',
                            borderRadius: 2,
                            cursor: 'nwse-resize',
                            boxShadow: '0 2px 4px rgba(0,0,0,0.2)',
                        }}
                    />
                    <div
                        className="resize-handle top-right"
                        onMouseDown={(e) => handleMouseDown(e, 'top-right')}
                        style={{
                            position: 'absolute',
                            top: -6,
                            right: -6,
                            width: 12,
                            height: 12,
                            background: '#d40c19',
                            border: '2px solid white',
                            borderRadius: 2,
                            cursor: 'nesw-resize',
                            boxShadow: '0 2px 4px rgba(0,0,0,0.2)',
                        }}
                    />
                    <div
                        className="resize-handle bottom-left"
                        onMouseDown={(e) => handleMouseDown(e, 'bottom-left')}
                        style={{
                            position: 'absolute',
                            bottom: -6,
                            left: -6,
                            width: 12,
                            height: 12,
                            background: '#d40c19',
                            border: '2px solid white',
                            borderRadius: 2,
                            cursor: 'nesw-resize',
                            boxShadow: '0 2px 4px rgba(0,0,0,0.2)',
                        }}
                    />
                    <div
                        className="resize-handle bottom-right"
                        onMouseDown={(e) => handleMouseDown(e, 'bottom-right')}
                        style={{
                            position: 'absolute',
                            bottom: -6,
                            right: -6,
                            width: 12,
                            height: 12,
                            background: '#d40c19',
                            border: '2px solid white',
                            borderRadius: 2,
                            cursor: 'nwse-resize',
                            boxShadow: '0 2px 4px rgba(0,0,0,0.2)',
                        }}
                    />
                </>
            )}
        </NodeViewWrapper>
    );
};

// TipTap extension
export const ResizableImage = Node.create({
    name: 'image',

    group: 'inline',

    inline: true,

    draggable: true,

    addAttributes() {
        return {
            src: {
                default: null,
            },
            alt: {
                default: null,
            },
            title: {
                default: null,
            },
            width: {
                default: null,
            },
            height: {
                default: null,
            },
            style: {
                default: null,
            },
        };
    },

    parseHTML() {
        return [
            {
                tag: 'img[src]',
            },
        ];
    },

    renderHTML({ HTMLAttributes }) {
        return ['img', mergeAttributes(HTMLAttributes)];
    },

    addNodeView() {
        return ReactNodeViewRenderer(ResizableImageComponent);
    },

    addCommands() {
        return {
            setImage: (options) => ({ commands }) => {
                return commands.insertContent({
                    type: this.name,
                    attrs: options,
                });
            },
        };
    },
});

export default ResizableImage;
