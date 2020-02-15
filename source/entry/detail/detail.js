import detail from '../../blocks/detail/detail';
import detailComplex from '../../blocks/detail/complex/detail-complex';
import detailDistrict from '../../blocks/detail/district/detail-district';

const dEl = document.querySelector('.detail');
if (dEl) {
	detail(dEl);
}

const dElC = document.querySelector('.detail--complex');
if (dElC) {
	detailComplex(dElC);
}

const dElD = document.querySelector('.detail-district');
if (dElD) {
	detailDistrict(dElD);
}
