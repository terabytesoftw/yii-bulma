<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bulma;

use InvalidArgumentException;
use JsonException;
use Yiisoft\Html\Html;

/**
 * ModalCard renders a modal window that can be toggled by clicking on a button.
 *
 * The following example will show the content enclosed between the {@see begin()} and {@see end()} calls within the
 * modal window:
 *
 * ```php
 * echo ModalCard::widget()
 *     ->title('Modal title')
 *     ->footer(
 *         Html::button('Cancel', ['class' => 'button'])
 *     )
 *     ->begin();
 *
 * echo 'Say hello...';
 *
 * echo ModalCard::end();
 * ```
 *
 * @link https://bulma.io/documentation/components/modal/
 */
final class ModalCard extends Widget
{
    public const SIZE_SMALL = 'is-small';
    public const SIZE_MEDIUM = 'is-medium';
    public const SIZE_LARGE = 'is-large';
    private const SIZE_ALL = [
        self::SIZE_SMALL,
        self::SIZE_MEDIUM,
        self::SIZE_LARGE,
    ];

    public const COLOR_PRIMARY = 'is-primary';
    public const COLOR_LINK = 'is-link';
    public const COLOR_INFO = 'is-info';
    public const COLOR_SUCCESS = 'is-success';
    public const COLOR_WARNING = 'is-warning';
    public const COLOR_DANGER = 'is-danger';
    private const COLOR_ALL = [
        self::COLOR_PRIMARY,
        self::COLOR_LINK,
        self::COLOR_INFO,
        self::COLOR_SUCCESS,
        self::COLOR_WARNING,
        self::COLOR_DANGER,
    ];

    private array $options = [];
    private array $contentOptions = [];
    private array $closeButtonOptions = [];
    private string $closeButtonSize = '';
    private bool $withoutCloseButton = true;
    private string $toggleButtonLabel = 'Toggle button';
    private string $toggleButtonSize = '';
    private string $toggleButtonColor = '';
    private array $toggleButtonOptions = [];
    private bool $withoutToggleButton = true;
    private string $title = '';
    private string $footer = '';
    private array $titleOptions = [];
    private array $headerOptions = [];
    private array $bodyOptions = [];
    private array $footerOptions = [];

    public function begin(): ?string
    {
        parent::begin();

        $this->buildOptions();

        $html = '';
        $html .= $this->renderToggleButton() . "\n";
        $html .= Html::openTag('div', $this->options) . "\n"; // .modal
        $html .= $this->renderBackgroundTransparentOverlay() . "\n"; // .modal-background
        $html .= Html::openTag('div', $this->contentOptions) . "\n"; // .modal-card
        $html .= $this->renderHeader();
        $html .= $this->renderBodyBegin() . "\n";

        return $html;
    }

    protected function run(): string
    {
        $html = '';
        $html .= $this->renderBodyEnd() . "\n";
        $html .= $this->renderFooter() . "\n";
        $html .= Html::closeTag('div') . "\n"; // .modal-card
        $html .= Html::closeTag('div'); // .modal

        return $html;
    }

    /**
     * Main container options.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return self
     */
    public function options(array $value): self
    {
        $new = clone $this;
        $new->options = $value;

        return $new;
    }

    /**
     * Main content container options.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return self
     */
    public function contentOptions(array $value): self
    {
        $new = clone $this;
        $new->contentOptions = $value;

        return $new;
    }

    /**
     * Toggle button label.
     *
     * @param string $value
     *
     * @return self
     */
    public function toggleButtonLabel(string $value): self
    {
        $new = clone $this;
        $new->toggleButtonLabel = $value;

        return $new;
    }

    /**
     * Toggle button options.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return self
     */
    public function toggleButtonOptions(array $value): self
    {
        $new = clone $this;
        $new->toggleButtonOptions = $value;

        return $new;
    }

    /**
     * Toggle button size.
     *
     * @param string $value
     *
     * @return self
     */
    public function toggleButtonSize(string $value): self
    {
        if (!in_array($value, self::SIZE_ALL)) {
            $values = implode('", "', self::SIZE_ALL);
            throw new InvalidArgumentException("Invalid size. Valid values are: \"$values\".");
        }

        $new = clone $this;
        $new->toggleButtonSize = $value;

        return $new;
    }

    /**
     * Toggle button color.
     *
     * @param string $value
     *
     * @return self
     */
    public function toggleButtonColor(string $value): self
    {
        if (!in_array($value, self::COLOR_ALL)) {
            $values = implode('", "', self::COLOR_ALL);
            throw new InvalidArgumentException("Invalid color. Valid values are: \"$values\".");
        }

        $new = clone $this;
        $new->toggleButtonColor = $value;

        return $new;
    }

    /**
     * Disable toggle button.
     *
     * @param bool $value
     *
     * @return self
     */
    public function withoutToggleButton(): self
    {
        $new = clone $this;
        $new->withoutToggleButton = false;

        return $new;
    }

    /**
     * Close button size.
     *
     * @param string $value
     *
     * @return self
     */
    public function closeButtonSize(string $value): self
    {
        if (!in_array($value, self::SIZE_ALL)) {
            $values = implode('"', self::SIZE_ALL);
            throw new InvalidArgumentException("Invalid size. Valid values are: \"$values\".");
        }

        $new = clone $this;
        $new->closeButtonSize = $value;

        return $new;
    }

    /**
     * Close button options
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return self
     */
    public function closeButtonOptions(array $value): self
    {
        $new = clone $this;
        $new->closeButtonOptions = $value;

        return $new;
    }

    /**
     * Disable close button.
     *
     * @param bool $value
     *
     * @return self
     */
    public function withoutCloseButton(): self
    {
        $new = clone $this;
        $new->withoutCloseButton = false;

        return $new;
    }

    /**
     * Header options.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return self
     */
    public function headerOptions(array $value): self
    {
        $new = clone $this;
        $new->headerOptions = $value;

        return $new;
    }

    /**
     * Body options.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return self
     */
    public function bodyOptions(array $value): self
    {
        $new = clone $this;
        $new->bodyOptions = $value;

        return $new;
    }

    /**
     * Footer options
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return self
     */
    public function footerOptions(array $value): self
    {
        $new = clone $this;
        $new->footerOptions = $value;

        return $new;
    }

    /**
     * The footer content in the modal window.
     *
     * @param string $value
     *
     * @return self
     */
    public function footer(string $value): self
    {
        $new = clone $this;
        $new->footer = $value;

        return $new;
    }

    /**
     * Title options.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return self
     */
    public function titleOptions(array $value): self
    {
        $new = clone $this;
        $new->titleOptions = $value;

        return $new;
    }

    /**
     * The title content in the modal window.
     *
     * @param string $value
     *
     * @return self
     */
    public function title(string $value): self
    {
        $new = clone $this;
        $new->title = $value;

        return $new;
    }

    /**
     * Renders the toggle button.
     *
     * @throws JsonException
     *
     * @return string
     */
    private function renderToggleButton(): string
    {
        if ($this->withoutToggleButton) {
            return Html::button($this->toggleButtonLabel, $this->toggleButtonOptions)->render();
        }

        return '';
    }

    /**
     * Renders the close button.
     *
     * @throws JsonException
     *
     * @return string
     */
    private function renderCloseButton(): string
    {
        if ($this->withoutCloseButton) {
            return Html::button('', $this->closeButtonOptions)->render();
        }

        return '';
    }

    /**
     * Renders header.
     *
     * @throws JsonException
     *
     * @return string
     */
    private function renderHeader(): string
    {
        $html = '';
        $html .= Html::openTag('header', $this->headerOptions) . "\n";
        $html .= Html::tag('p', $this->title, $this->titleOptions) . "\n";
        $html .= $this->renderCloseButton() . "\n";
        $html .= Html::closeTag('header') . "\n";

        return $html;
    }

    /**
     * Renders begin body tag.
     *
     * @throws JsonException
     *
     * @return string
     */
    private function renderBodyBegin(): string
    {
        return Html::openTag('section', $this->bodyOptions);
    }

    /**
     * Renders end body tag.
     *
     * @throws JsonException
     *
     * @return string
     */
    private function renderBodyEnd(): string
    {
        return Html::closeTag('section');
    }

    /**
     * Renders the footer.
     *
     * @throws JsonException
     *
     * @return string
     */
    private function renderFooter(): string
    {
        return Html::tag('footer', $this->footer, $this->footerOptions)->render();
    }

    /**
     * Renders the background transparent overlay.
     *
     * @throws JsonException
     *
     * @return string
     */
    private function renderBackgroundTransparentOverlay(): string
    {
        return Html::tag('div', '', ['class' => 'modal-background'])->render();
    }

    private function buildOptions(): void
    {
        $this->options['id'] ??= "{$this->getId()}-modal";
        $this->options = $this->addOptions($this->options, 'modal');

        $this->closeButtonOptions = $this->addOptions($this->closeButtonOptions, 'delete');
        $this->closeButtonOptions['aria-label'] = 'close';

        if ($this->closeButtonSize !== '') {
            Html::addCssClass($this->closeButtonOptions, $this->closeButtonSize);
        }

        $this->toggleButtonOptions = $this->addOptions($this->toggleButtonOptions, 'button');
        $this->toggleButtonOptions['data-target'] = '#' . $this->options['id'];
        $this->toggleButtonOptions['aria-haspopup'] = 'true';

        if ($this->toggleButtonSize !== '') {
            Html::addCssClass($this->toggleButtonOptions, $this->toggleButtonSize);
        }

        if ($this->toggleButtonColor !== '') {
            Html::addCssClass($this->toggleButtonOptions, $this->toggleButtonColor);
        }

        $this->contentOptions = $this->addOptions($this->contentOptions, 'modal-card');
        $this->headerOptions = $this->addOptions($this->headerOptions, 'modal-card-head');
        $this->titleOptions = $this->addOptions($this->titleOptions, 'modal-card-title');
        $this->bodyOptions = $this->addOptions($this->bodyOptions, 'modal-card-body');
        $this->footerOptions = $this->addOptions($this->footerOptions, 'modal-card-foot');
    }
}
