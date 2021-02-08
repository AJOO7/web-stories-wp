/*
 * Copyright 2020 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * External dependencies
 */
import styled from 'styled-components';

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import { CarouselScrollForward, CarouselScrollBack } from './carouselScroll';
import CarouselMenu from './carouselMenu';
import CarouselList from './carouselList';
import useCarousel from './useCarousel';
import { MENU_GUTTER, BUTTON_GUTTER } from './constants';

const Wrapper = styled.section`
  position: relative;
  display: grid;
  grid:
    /* Note the two empty 1fr areas each side of the buttons - that's on purpose */
    '. . prev-navigation carousel next-navigation . menu' auto /
    ${MENU_GUTTER}px
    1fr
    ${BUTTON_GUTTER}px
    auto
    ${BUTTON_GUTTER}px
    1fr
    ${MENU_GUTTER}px;
  width: 100%;
  height: 100%;
`;

const Area = styled.div`
  grid-area: ${({ area }) => area};
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
`;

function CarouselLayout() {
  const { numPages } = useCarousel(({ state: { numPages } }) => ({ numPages }));

  if (numPages <= 0) {
    return null;
  }

  return (
    <Wrapper aria-label={__('Page Carousel', 'web-stories')}>
      <Area area="prev-navigation">
        <CarouselScrollBack />
      </Area>
      <Area area="carousel">
        <CarouselList />
      </Area>
      <Area area="next-navigation">
        <CarouselScrollForward />
      </Area>
      <Area area="menu">
        <CarouselMenu />
      </Area>
    </Wrapper>
  );
}

export default CarouselLayout;